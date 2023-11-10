// Program.cs
using Microsoft.AspNetCore.Authentication.JwtBearer;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Diagnostics;
using Microsoft.IdentityModel.Tokens;
using Pomelo.EntityFrameworkCore.MySql.Infrastructure;
using PublicTalk_Manager.Helpers;
using System.Text;


var builder = WebApplication.CreateBuilder(args);

// Add services to the container.
builder.Services.AddRazorPages();
builder.Services.AddControllers();
builder.Services.AddSession();

builder.Services.AddDbContext<MyDbContext>(options =>
    options.UseMySql(
        builder.Configuration.GetConnectionString("DefaultConnection"),
        new MySqlServerVersion(new Version(5, 7, 24)),
        mySqlOptions =>
        {
            mySqlOptions.EnableRetryOnFailure(
                maxRetryCount: 2,
                maxRetryDelay: TimeSpan.FromSeconds(10),
                errorNumbersToAdd: null);
        }
    )
    //.EnableSensitiveDataLogging() // This will log sensitive data, be cautious using in production!
    //.LogTo(Console.WriteLine, LogLevel.Information)  // Log to console
    //.AddInterceptors(new[] { new CustomSaveChangesInterceptor() })
);

// JWT Validator
builder.Services.AddAuthentication(JwtBearerDefaults.AuthenticationScheme)
    .AddJwtBearer(options =>
    {
        options.TokenValidationParameters = new TokenValidationParameters
        {
            ValidateIssuer = true,
            ValidateAudience = true,
            ValidateLifetime = true,
            ValidateIssuerSigningKey = true,

            ValidIssuer = "khronos.pro",
            ValidAudience = "khronos.pro",
            IssuerSigningKey = new SymmetricSecurityKey(Encoding.UTF8.GetBytes("An6WebAppN@G1n@w@n1R@ym0nd!?!@##")),

            ClockSkew = TimeSpan.Zero // Adjusts the token validation time, useful if there are minor time discrepancies between servers
        };

    });

// JWT Helper
builder.Services.AddTransient<JwtHelper>();

var app = builder.Build();

// Configure the HTTP request pipeline.
if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Error");
    // The default HSTS value is 30 days. You may want to change this for production scenarios, see https://aka.ms/aspnetcore-hsts.
    app.UseHsts();
}

app.UseHttpsRedirection();
app.UseStaticFiles();
app.UseRouting();
app.UseAuthentication();
app.UseAuthorization();
app.MapRazorPages();
app.MapControllers();
app.Run();
