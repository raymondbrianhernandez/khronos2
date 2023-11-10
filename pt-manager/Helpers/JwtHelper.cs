using Microsoft.IdentityModel.Tokens;
using System.IdentityModel.Tokens.Jwt;
using System.Text.Json;
using System.Text;
using System.Security.Cryptography;

namespace PublicTalk_Manager.Helpers
{
    public class JwtHelper
    {
        private readonly IConfiguration _configuration;
        private readonly ILogger _logger;

        public JwtHelper(IConfiguration configuration, ILogger<JwtHelper> logger)
        {
            _configuration = configuration;
            _logger = logger;
        }

        public Dictionary<string, string> ExtractJwtClaims(string token)
        {
            var jwtToken = new JwtSecurityToken(token);
            var dataClaim = jwtToken.Claims.FirstOrDefault(c => c.Type == "data")?.Value;
            var dataDictionary = JsonSerializer.Deserialize<Dictionary<string, object>>(dataClaim);

            return new Dictionary<string, string>
        {
            { "Admin", dataDictionary["admin"]?.ToString() },
            { "Owner", dataDictionary["owner"]?.ToString() },
            { "Congregation", dataDictionary["congregation"]?.ToString() },
            { "Username", dataDictionary["username"]?.ToString() },
            { "IsLoggedIn", dataDictionary["logged_in"]?.ToString() }
        };
        }

        public bool ValidateJwtToken(string token)
        {
            var key = _configuration["JwtKey"];
            var keyBytes = Encoding.UTF8.GetBytes(key);
            var computedKid = BitConverter.ToString(SHA256.Create().ComputeHash(keyBytes)).Replace("-", "").ToLower();

            var jwtToken = new JwtSecurityToken(token);

            if (jwtToken.Header.Kid != computedKid)
            {
                _logger.LogError("Kid values don't match.");
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
                ValidAlgorithms = new[] { "HS256" }
            };

            var tokenHandler = new JwtSecurityTokenHandler();

            try
            {
                tokenHandler.ValidateToken(token, validationParameters, out _);
            }
            catch
            {
                return false;
            }

            return true;
        }
    }
}
