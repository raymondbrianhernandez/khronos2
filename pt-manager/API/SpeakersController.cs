// API/SpeakersController.cs
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using PublicTalk_Manager.Model;

[Route("api/[controller]")]
[ApiController]
public class SpeakersController : ControllerBase
{
    private readonly MyDbContext _context;

    public SpeakersController(MyDbContext context)
    {
        _context = context;
        Console.WriteLine("SpeakersController instantiated");
    }

    [HttpDelete("delete/{id}")]
    public async Task<IActionResult> DeleteSpeaker(int id)
    {
        var speaker = await _context.Speakers.FindAsync(id);
        if (speaker == null)
        {
            return NotFound();
        }

        _context.Speakers.Remove(speaker);
        await _context.SaveChangesAsync();

        return Ok();
    }

    [HttpPost("edit")]
    public async Task<IActionResult> EditSpeaker([FromBody] SpeakerEditDto dto)
    {
        Console.WriteLine("EditSpeaker action called with DTO: " + dto.Name);
        var speaker = await _context.Speakers.FindAsync(dto.Id);
        if (speaker == null)
        {
            return NotFound();
        }

        speaker.Name = dto.Name;
        speaker.Privilege = dto.Privilege;
        speaker.Talk_Counter = dto.Talk_Counter;

        await _context.SaveChangesAsync();

        return Ok();
    }
}

public class SpeakerEditDto
{
    public int Id { get; set; }
    public string Name { get; set; }
    public string Privilege { get; set; }
    public int Talk_Counter { get; set; } 
}

