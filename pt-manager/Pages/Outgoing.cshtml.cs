using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.Extensions.Logging;
using Microsoft.Extensions.Configuration;
using System.IdentityModel.Tokens.Jwt;
using Microsoft.IdentityModel.Tokens;
using System.Text;
using System.Security.Cryptography;
using PublicTalk_Manager.Model;
using Microsoft.EntityFrameworkCore;
using System.Text.Json;
using PublicTalk_Manager.Helpers;
using Microsoft.AspNetCore.Http;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System;

namespace PublicTalk_Manager.Pages
{
    public class OutgoingModel : BasePageModel
    {
        public OutgoingModel(ILogger<ManageModel> logger, IConfiguration configuration, MyDbContext context, JwtHelper jwtHelper) // Added JwtHelper jwtHelper
            : base(logger, configuration, context, jwtHelper) { }

        private int _selectedYear = 2024;
        [BindProperty]
        public int SelectedYear
        {
            get => _selectedYear;
            set
            {
                if (value < 2024 || value > 2034)
                    _selectedYear = 2024;
                else
                    _selectedYear = value;
            }
        }
        public List<Outgoing> Outgoing { get; set; }
        public List<Outlines> Outlines { get; set; }
        public List<Speakers> ListOfSpeakers { get; set; }
        public async Task<IActionResult> OnGetAsync()
        {
            if (!ValidateJwtToken())
                return Redirect("https://khronos.pro");

            PopulateJwtClaims();
            SetTokenData();

            if (JwtClaims["IsLoggedIn"]?.ToLower() != "true")
                return Redirect("https://khronos.pro");

            return Page();
        }

        public async Task<IActionResult> OnPostOutgoingSpeakersAsync()
        {
            if (!ValidateJwtToken())
                return Redirect("https://khronos.pro");

            PopulateJwtClaims();
            SetTokenData();

            await EnsureSundaysExistForYearOutgoing(SelectedYear);

            try
            {
                Outgoing = await _context.Outgoing
                    .Where(s => s.Date.Year == SelectedYear && s.Congregation_From == Congregation)
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

        public async Task<IActionResult> OnPostUpdateOutgoingAssignmentsAsync()
        {
            if (!ValidateJwtToken())
                return Redirect("https://khronos.pro");

            PopulateJwtClaims();
            SetTokenData();

            try
            {
                foreach (var key in Request.Form.Keys)
                {
                    var value = Request.Form[key].ToString();

                    if (!string.IsNullOrWhiteSpace(value))
                    {
                        DateTime date;
                        var keyParts = key.Split('_');
                        string propertyName = keyParts.Length > 1 ? string.Join("_", keyParts.Take(keyParts.Length - 1)) : keyParts[0];
                        string dateString = keyParts[keyParts.Length - 1];

                        if (DateTime.TryParse(dateString, out date))
                        {
                            var outgoing = await _context.Outgoing.FirstOrDefaultAsync(o => o.Date == date && o.Year == date.Year);
                            if (outgoing != null)
                            {
                                var propertyInfo = typeof(Outgoing).GetProperty(propertyName);
                                if (propertyInfo != null)
                                {
                                    if (propertyInfo.PropertyType == typeof(int?))
                                    {
                                        propertyInfo.SetValue(outgoing, int.Parse(value));
                                    }
                                    else
                                    {
                                        propertyInfo.SetValue(outgoing, value);
                                    }
                                }
                                _context.Outgoing.Update(outgoing);
                            }
                            else
                            {
                                _logger.LogWarning($"No outgoing entry found for date: {date}");
                            }
                        }
                        else
                        {
                            _logger.LogWarning($"Failed to parse date from key: {key}");
                        }
                    }
                }

                await _context.SaveChangesAsync();
                TempData["Message"] = "Your changes have been saved";
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error updating the outgoing assignments database");
                TempData["Message"] = "Error updating the outgoing assignments database";
            }

            return RedirectToPage();
        }

    }
}
