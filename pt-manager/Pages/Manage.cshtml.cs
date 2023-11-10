// Manage.cshtml.cs
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
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


namespace PublicTalk_Manager.Pages
{
    public class ManageModel : BasePageModel
    {
        public ManageModel(ILogger<ManageModel> logger, IConfiguration configuration, MyDbContext context, JwtHelper jwtHelper) // Added JwtHelper jwtHelper
            : base(logger, configuration, context, jwtHelper){}

        public List<Speakers> Speakers { get; set; }

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
                Speakers = await _context.Speakers
                    .Where(s => s.Congregation == Congregation)
                    .ToListAsync();
                _logger.LogInformation($"Fetched {Speakers.Count} speakers for congregation: {Congregation}");
            }
            else
            {
                _logger.LogWarning("Congregation is empty or null.");
                Speakers = new List<Speakers>();
            }

            return Page();
        }

        public async Task<IActionResult> OnPostAsync(string name, string privilege)
        {
            if (ModelState.IsValid)
            {
                PopulateJwtClaims();

                var newSpeaker = new Speakers
                {
                    Congregation = JwtClaims["Congregation"],
                    Name = name,
                    Privilege = privilege
                };

                _context.Speakers.Add(newSpeaker);
                await _context.SaveChangesAsync();

                Speakers = await _context.Speakers
                    .Where(s => s.Congregation == JwtClaims["Congregation"])
                    .ToListAsync();

                return RedirectToPage("./Manage");
            }

            return Page();
        }
    }
}
