using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Claims;
using PublicTalk_Manager.Model;
using Microsoft.IdentityModel.Tokens;
using System.IdentityModel.Tokens.Jwt;
using System.Text.Json;
using System.Text;
using System.Security.Cryptography;
using PublicTalk_Manager.Helpers;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;

namespace PublicTalk_Manager.Pages
{
    public class PT_OverseersModel : BasePageModel
    {
        public PT_OverseersModel(ILogger<PT_OverseersModel> logger, IConfiguration configuration, MyDbContext context, JwtHelper jwtHelper)
            : base(logger, configuration, context, jwtHelper) { }

        public List<PT_Overseers> PT_Overseers { get; set; }

        [BindProperty]
        public PT_Overseers NewOverseer { get; set; }

        public async Task<IActionResult> OnGetAsync()
        {
            if (!ValidateJwtToken())
                return Redirect("https://khronos.pro");

            PopulateJwtClaims();
            SetTokenData();

            if (JwtClaims["IsLoggedIn"]?.ToLower() != "true")
                return Redirect("https://khronos.pro");

            if (!string.IsNullOrEmpty(Congregation))
            {
                PT_Overseers = await _context.PT_Overseers
                    .Where(s => s.Congregation_Owner == Congregation)
                    .ToListAsync();
            }
            else
            {
                _logger.LogWarning("Congregation is empty or null.");
                PT_Overseers = new List<PT_Overseers>();
            }

            return Page();
        }

        public async Task<IActionResult> OnPostAsync()
        {
            if (!ValidateJwtToken())
                return Redirect("https://khronos.pro");

            PopulateJwtClaims();
            SetTokenData();

            // Check if the user is logged in and has the right admin level
            if (JwtClaims["IsLoggedIn"]?.ToLower() != "true" || (JwtClaims["Admin"]?.ToLower() != "super admin" && JwtClaims["Admin"]?.ToLower() != "pt admin"))
                return Forbid();

            // Check if ModelState is valid
            if (!ModelState.IsValid)
            {
                return Page();
            }

            // Set the Congregation_Owner based on the JWT claim
            NewOverseer.Congregation_Owner = JwtClaims["Congregation"];

            // Add the new overseer
            _context.PT_Overseers.Add(NewOverseer);
            await _context.SaveChangesAsync();

            // Redirect to the same page to see the new entry
            return RedirectToPage("./PT_Overseers");
        }
    }
}
