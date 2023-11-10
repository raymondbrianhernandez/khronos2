using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.IdentityModel.Tokens;
using PublicTalk_Manager.Pages;
using System.IdentityModel.Tokens.Jwt;
using System.Text.Json;
using System.Text;
using System.Security.Cryptography;
using System.Collections.Generic;
using PublicTalk_Manager.Helpers;
using Microsoft.EntityFrameworkCore;

namespace PublicTalk_Manager.Model
{
    public class BasePageModel : PageModel
    {
        protected readonly ILogger<BasePageModel> _logger;
        protected readonly IConfiguration _configuration;
        protected readonly MyDbContext _context;
        protected readonly JwtHelper _jwtHelper;
        protected JwtSecurityToken jwtToken;
        public Dictionary<string, string> JwtClaims { get; set; } = new Dictionary<string, string>();

        public string Admin { get; set; }
        public string Owner { get; set; }
        public string Congregation { get; set; }

        public BasePageModel(ILogger<BasePageModel> logger, IConfiguration configuration, MyDbContext context, JwtHelper jwtHelper)
        {
            _logger = logger;
            _configuration = configuration;
            _context = context;
            _jwtHelper = jwtHelper;
        }
        public ILogger Logger => _logger;

        protected void PopulateJwtClaims()
        {
            var token = Request.Cookies["auth_token"];
            var jwtToken = new JwtSecurityToken(token);
            var dataClaim = jwtToken.Claims.FirstOrDefault(c => c.Type == "data")?.Value;
            var dataDictionary = JsonSerializer.Deserialize<Dictionary<string, object>>(dataClaim);

            JwtClaims["Admin"] = dataDictionary["admin"]?.ToString();
            JwtClaims["Owner"] = dataDictionary["owner"]?.ToString();
            JwtClaims["Congregation"] = dataDictionary["congregation"]?.ToString();
            JwtClaims["Username"] = dataDictionary["username"]?.ToString();
            JwtClaims["IsLoggedIn"] = dataDictionary["logged_in"]?.ToString();
        }

        protected bool ValidateJwtToken()
        {
            var key = "An6WebAppN@G1n@w@n1R@ym0nd!?!@##";
            var keyBytes = Encoding.UTF8.GetBytes(key);
            var computedKid = BitConverter.ToString(SHA256.Create().ComputeHash(keyBytes)).Replace("-", "").ToLower();
            var token = Request.Cookies["auth_token"];

            if (string.IsNullOrEmpty(token))
            {
                _logger.LogError("The JWT token is missing or empty.");
                return false;
            }

            TokenValidationParameters validationParameters = new TokenValidationParameters
            {
                ValidIssuer = "khronos.pro",
                ValidAudience = "khronos.pro",
                IssuerSigningKey = new SymmetricSecurityKey(keyBytes),
                ValidateIssuerSigningKey = true,
                ValidateLifetime = true,
                ClockSkew = TimeSpan.Zero,
                ValidAlgorithms = new[] { "HS256" },
            };

            var tokenHandler = new JwtSecurityTokenHandler();

            try
            {
                tokenHandler.ValidateToken(token, validationParameters, out _);
                return true;
            }
            catch (SecurityTokenExpiredException ex)
            {
                _logger.LogError(ex, "JWT token has expired.");
                Response.Redirect("https://khronos.pro");
                return false;
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "JWT token validation failed.");
                return false;
            }
        }

        protected void SetTokenData()
        {
            Admin = JwtClaims["Admin"];
            Owner = JwtClaims["Owner"];
            Congregation = JwtClaims["Congregation"];
        }

        public List<DateTime> GetAllSundays(int year)
        {
            var dates = new List<DateTime>();
            DateTime current = new DateTime(year, 1, 1);
            while (current.Year == year)
            {
                if (current.DayOfWeek == DayOfWeek.Sunday)
                {
                    dates.Add(current);
                }
                current = current.AddDays(1);
            }
            return dates;
        }

        protected async Task EnsureSundaysExistForYear(int year)
        {
            try
            {
                // Count how many Sundays of the given year exist in the database for the specified congregation
                int countInDb = await _context.Schedule.CountAsync(s => s.Date.Year == year && s.Congregation_To == JwtClaims["Congregation"]);

                // Get all Sundays for the given year
                var allSundays = GetAllSundays(year);

                // Check if the count of Sundays in the database matches the actual count of Sundays in the year
                if (countInDb != allSundays.Count)
                {
                    // Find which Sundays are missing in the database
                    var missingSundays = allSundays.Except(_context.Schedule.Where(s => s.Date.Year == year && s.Congregation_To == JwtClaims["Congregation"]).Select(s => s.Date));

                    // Add the missing Sundays to the database
                    foreach (var sunday in missingSundays)
                    {
                        var newSchedule = new Schedule
                        {
                            Year = year,
                            Date = sunday,
                            Congregation_To = JwtClaims["Congregation"]
                        };

                        _context.Schedule.Add(newSchedule);
                    }

                    // Save the changes to the database
                    await _context.SaveChangesAsync();
                }
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error ensuring Sundays exist for the year.");
            }
        }

        protected async Task EnsureSundaysExistForYearOutgoing(int year)
        {
            try
            {
                // Count how many Sundays of the given year exist in the database for the specified congregation
                int countInDb = await _context.Outgoing.CountAsync(s => s.Date.Year == year && s.Congregation_From == JwtClaims["Congregation"]);

                // Get all Sundays for the given year
                var allSundays = GetAllSundays(year);

                // Check if the count of Sundays in the database matches the actual count of Sundays in the year
                if (countInDb != allSundays.Count)
                {
                    // Find which Sundays are missing in the database
                    var missingSundays = allSundays.Except(_context.Outgoing.Where(s => s.Date.Year == year && s.Congregation_From == JwtClaims["Congregation"]).Select(s => s.Date));

                    // Add the missing Sundays to the database
                    foreach (var sunday in missingSundays)
                    {
                        var newOutgoingSchedule = new Outgoing
                        {
                            Year = year,
                            Date = sunday,
                            Congregation_From = JwtClaims["Congregation"]
                        };

                        _context.Outgoing.Add(newOutgoingSchedule);
                    }

                    // Save the changes to the database
                    await _context.SaveChangesAsync();
                }
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error ensuring Sundays exist for the year.");
            }
        }
    }
}
