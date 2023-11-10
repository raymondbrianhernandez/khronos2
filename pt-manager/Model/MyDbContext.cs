// MyDbContext.cs
using Microsoft.EntityFrameworkCore;
using PublicTalk_Manager.Model;

public class MyDbContext : DbContext
{
    public MyDbContext(DbContextOptions<MyDbContext> options) : base(options) { }

    public DbSet<Outlines> Outlines { get; set; }
    public DbSet<Schedule> Schedule { get; set; }
    public DbSet<Speakers> Speakers { get; set; }
    public DbSet<Outgoing> Outgoing { get; set; }
    public DbSet<PT_Overseers> PT_Overseers { get; set; }
    public DbSet<OutlineStats> OutlineStats { get; set; }
    public DbSet<History> History { get; set; }
    // ... other DbSets for other tables ...
}
