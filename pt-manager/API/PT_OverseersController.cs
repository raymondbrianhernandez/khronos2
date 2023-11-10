// API/PT_OverseersController.cs
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using PublicTalk_Manager.Model;
using System.ComponentModel.DataAnnotations;

[Route("api/[controller]")]
[ApiController]
public class PT_OverseersController : ControllerBase
{
    private readonly MyDbContext _context;

    public PT_OverseersController(MyDbContext context)
    {
        _context = context;
    }

    [HttpDelete("delete/{id}")]
    public async Task<IActionResult> DeleteOverseer(int id)
    {
        var overseer = await _context.PT_Overseers.FindAsync(id);
        if (overseer == null)
        {
            return NotFound();
        }

        _context.PT_Overseers.Remove(overseer);
        await _context.SaveChangesAsync();

        return Ok();
    }

    [HttpPost("edit")]
    public async Task<IActionResult> EditOverseer([FromBody] OverseerEditDto dto)
    {
        if (!ModelState.IsValid)
        {
            return BadRequest(ModelState);
        }

        var overseer = await _context.PT_Overseers.FindAsync(dto.Id);
        if (overseer == null)
        {
            return NotFound();
        }

        overseer.Congregation = dto.Congregation;
        overseer.Overseer = dto.Overseer;
        overseer.Contact1 = dto.Contact1;
        overseer.Assistant = dto.Assistant;
        overseer.Contact2 = dto.Contact2;
        // Make sure to update other properties as needed

        try
        {
            await _context.SaveChangesAsync();
            return NoContent();
        }
        catch (DbUpdateConcurrencyException ex)
        {
            // Handle the concurrency exception
            // Log the exception
            return StatusCode(409, ex.Message);
        }
        catch (Exception ex)
        {
            // Handle other exceptions
            // Log the exception
            return StatusCode(500, ex.Message);
        }
    }
}

public class OverseerEditDto
{
    public int Id { get; set; }
    public string? Congregation_Owner { get; set; }
    public string? Congregation { get; set; }
    public string? Overseer { get; set; }
    public string? Contact1 { get; set; }
    public string? Assistant { get; set; }
    public string? Contact2 { get; set; }
}

