// index.cshtml.cs
using Microsoft.AspNetCore.Mvc;
using System.IdentityModel.Tokens.Jwt;
using Microsoft.IdentityModel.Tokens;
using System.Text;
using System.Security.Cryptography;
using PublicTalk_Manager.Model;
using Microsoft.EntityFrameworkCore;
using System.Text.Json;
using PublicTalk_Manager.Helpers;
using Microsoft.AspNetCore.Http;


namespace PublicTalk_Manager.Pages 
{
    public class IndexModel : BasePageModel
    {
        public IndexModel(ILogger<ManageModel> logger, IConfiguration configuration, MyDbContext context, JwtHelper jwtHelper)
            : base(logger, configuration, context, jwtHelper) {}

        private int _selectedYear = 2024;
        [BindProperty]
        public int SelectedYear 
        { 
            get => _selectedYear;
            set
            {
                if (value < 2023 || value > 2034)
                    _selectedYear = 2023;
                else
                    _selectedYear = value;
            }
        }
        public List<Schedule> Schedules { get; set; }
        public List<Outlines> Outlines { get; set; }
        public List<Speakers> ListOfSpeakers { get; set; }
        public List<History> History { get; set; }

        public IActionResult OnGetAsync()
        {
            if (!ValidateJwtToken())
                return Redirect("https://khronos.pro");

            PopulateJwtClaims();
            SetTokenData();

            if (JwtClaims["IsLoggedIn"]?.ToLower() != "true")
                return Redirect("https://khronos.pro");

            return Page();
        }

        public async Task<IActionResult> OnPostAssignSpeakersAsync()
        {
            if (!ValidateJwtToken())
                return Redirect("https://khronos.pro");

            PopulateJwtClaims();
            SetTokenData();

            await EnsureSundaysExistForYear(SelectedYear);

            try
            {
                Schedules = await _context.Schedule
                    .Where(s => s.Date.Year == SelectedYear && s.Congregation_To == Congregation)
                    .ToListAsync();

                Outlines = await _context.Outlines.ToListAsync();

                ListOfSpeakers = await _context.Speakers.ToListAsync();
            }
            catch (Exception ex)
            {
                TempData["Error"] = $"Can't connect to the database. Error: {ex.Message}";
            }

            return Page();
        }

        public async Task<IActionResult> OnPostUpdateAssignmentsAsync()
        {
            if (!ValidateJwtToken())
                return Redirect("https://khronos.pro");

            PopulateJwtClaims();
            SetTokenData();

            var congregation = JwtClaims["Congregation"].ToString();

            try
            {
                var historyUpdates = new List<History>();

                foreach (var key in Request.Form.Keys)
                {
                    var value = Request.Form[key].ToString();
                    if (!string.IsNullOrWhiteSpace(value))
                    {
                        DateTime date;
                        var keyParts = key.Split('_');
                        string propertyName = keyParts.Length > 2 ? $"{keyParts[0]}_{keyParts[1]}" : keyParts[0];
                        string dateString = keyParts[keyParts.Length - 1];

                        if (DateTime.TryParse(dateString, out date))
                        {
                            var schedule = await _context.Schedule.FirstOrDefaultAsync(s => s.Date == date);
                            if (schedule == null)
                            {
                                schedule = new Schedule { Date = date };
                                _context.Schedule.Add(schedule);
                            }

                            // Update Schedule from form input
                            UpdateScheduleFromFormInput(schedule, propertyName, value, dateString);

                            // Prepare History updates, which will be applied later.
                            var history = historyUpdates.FirstOrDefault(h => h.Date == date && h.Congregation_Owner == congregation);
                            if (history == null)
                            {
                                history = new History
                                {
                                    Date = date,
                                    Congregation_Owner = congregation
                                };
                                historyUpdates.Add(history);
                            }

                            // Update History from the same form input
                            UpdateHistoryFromFormInput(history, propertyName, value, dateString);
                        }
                        else
                        {
                            _logger.LogWarning($"Failed to parse date from: {dateString}");
                        }
                    }
                }

                // Apply History updates or additions
                foreach (var history in historyUpdates)
                {
                    var existingHistory = await _context.History.FirstOrDefaultAsync(h => h.Date == history.Date && h.Congregation_Owner == history.Congregation_Owner);
                    if (existingHistory != null)
                    {
                        existingHistory.Name = history.Name;
                        existingHistory.Congregation = history.Congregation;
                        existingHistory.Outline_No = history.Outline_No;
                    }
                    else
                    {
                        _context.History.Add(history);
                    }
                }

                // Save all changes to the database
                await _context.SaveChangesAsync();
                TempData["Message"] = "Your changes have been saved.";
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error updating database");
                TempData["Message"] = $"Error updating database: {ex.Message}";
            }

            return RedirectToPage();
        }

        private void UpdateScheduleFromFormInput(Schedule schedule, string propertyName, string value, string dateString)
        {
            switch (propertyName)
            {
                case "Speaker_From":
                    schedule.Speaker = value;
                    break;
                case "Speaker":
                    var inputKey = $"Speaker_From_{dateString}";
                    if (string.IsNullOrWhiteSpace(Request.Form[inputKey]))
                    {
                        schedule.Speaker = value;
                    }
                    break;
                case "Song":
                    if (int.TryParse(value, out int songNumber))
                    {
                        schedule.Song = songNumber;
                    }
                    else
                    {
                        _logger.LogWarning($"Invalid song number: {value} for date: {dateString}");
                    }
                    break;
                case "Congregation_From":
                    schedule.Congregation_From = value;
                    break;
                case "Privilege":
                    schedule.Privilege = value;
                    break;
                case "Title":
                    schedule.Title = value;
                    
                    break;
                case "Chairman":
                    schedule.Chairman = value;
                    break;
                case "Note":
                    schedule.Note = value;
                    break;
                // Add more cases as needed for other properties
                default:
                    _logger.LogWarning($"Unknown property: {propertyName} for date: {dateString}");
                    break;
            }
        }

        private void UpdateHistoryFromFormInput(History history, string propertyName, string value, string dateString)
        {
            switch (propertyName)
            {
                case "Speaker": 
                case "Speaker_From":
                    history.Name = value; // Assuming 'Name' corresponds to 'Speaker' in History
                    break;
                case "Congregation_From":
                    history.Congregation = value; // Assuming 'Congregation' corresponds to 'Congregation_From' in History
                    break;
                case "Title":
                    history.Outline_No = LookupOutlineNoByTitle(value);
                    break;
                default:
                    _logger.LogWarning($"Unknown property: {propertyName} for date: {dateString}");
                    break;
            }
        }

        private int? LookupOutlineNoByTitle(string title)
        {
            var outline = _context.Outlines.FirstOrDefault(o => o.Title == title);

            return outline?.Outline_No;
        }
    }
}