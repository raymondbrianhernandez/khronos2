// outlines.cshtml.cs
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Logging;
using System.IdentityModel.Tokens.Jwt;
using Microsoft.IdentityModel.Tokens;
using System.Text;
using System.Security.Cryptography;
using Microsoft.IdentityModel.Logging;
using PublicTalk_Manager.Model;
using Microsoft.EntityFrameworkCore;
using PublicTalk_Manager.Helpers;
using System.Text.Json;


namespace PublicTalk_Manager.Pages
{
    public class OutlinesModel : BasePageModel
    {
        public OutlinesModel(ILogger<ManageModel> logger, IConfiguration configuration, MyDbContext context, JwtHelper jwtHelper) // Added JwtHelper jwtHelper
            : base(logger, configuration, context, jwtHelper) { }
        public string Language { get; set; } = "all";
        public List<Outlines> Outlines { get; set; }
        public List<History> History { get; set; }
        public string SearchTitle { get; set; }
        
        public async Task<IActionResult> OnGetAsync(string language = "all", string searchTitle = "")
        {
            if (!ValidateJwtToken())
                return Redirect("https://khronos.pro");

            PopulateJwtClaims();
            SetTokenData();

            History = await _context.History.ToListAsync();

            // Extract language claim from JWT
            Language = language;
            var jwtLanguageClaim = jwtToken.Claims.FirstOrDefault(c => c.Type == "language")?.Value;
            if (!string.IsNullOrEmpty(jwtLanguageClaim))
            {
                Language = jwtLanguageClaim;
            }

            // Check the dropdown selection
            if (!string.IsNullOrEmpty(language) && language != "all")
            {
                Language = language;
            }

            /******************** SEARCH FUNCTION - START ********************/
            SearchTitle = searchTitle;

            IQueryable<Outlines> searchQuery = _context.Outlines;

            if (Language == "english" || Language == "tagalog")
            {
                searchQuery = searchQuery.Where(o => o.Language == Language); // Adjust "o.Language" based on your actual column
            }

            if (!string.IsNullOrWhiteSpace(SearchTitle))
            {
                if (int.TryParse(SearchTitle, out int outlineNo))
                {
                    searchQuery = searchQuery.Where(o => o.Outline_No == outlineNo);
                }
                else
                {
                    searchQuery = searchQuery.Where(o => o.Title.Contains(SearchTitle));
                }
            }

            Outlines = await searchQuery.ToListAsync();
            /******************** SEARCH FUNCTION - END ********************/

            if (JwtClaims["IsLoggedIn"]?.ToLower() != "true")
                return Redirect("https://khronos.pro");

            return Page();
        }

        private void PopulateJwtClaims()
        {
            var token = Request.Cookies["auth_token"];
            jwtToken = new JwtSecurityToken(token);
            var dataClaim = jwtToken.Claims.FirstOrDefault(c => c.Type == "data")?.Value;
            var dataDictionary = JsonSerializer.Deserialize<Dictionary<string, object>>(dataClaim);

            JwtClaims["Admin"] = dataDictionary["admin"]?.ToString();
            JwtClaims["Owner"] = dataDictionary["owner"]?.ToString();
            JwtClaims["Congregation"] = dataDictionary["congregation"]?.ToString();
            JwtClaims["Username"] = dataDictionary["username"]?.ToString();
            JwtClaims["IsLoggedIn"] = dataDictionary["logged_in"]?.ToString();
        }

        private bool ValidateJwtToken()
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

        private void SetTokenData()
        {
            Admin = JwtClaims["Admin"];
            Owner = JwtClaims["Owner"];
            Congregation = JwtClaims["Congregation"];
        }
    }
}