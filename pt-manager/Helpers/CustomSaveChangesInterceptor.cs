namespace PublicTalk_Manager.Helpers
{
    using Microsoft.EntityFrameworkCore;
    using Microsoft.EntityFrameworkCore.Diagnostics;
    using System.Threading;
    using System.Threading.Tasks;

    public class CustomSaveChangesInterceptor : SaveChangesInterceptor
    {
        public override ValueTask<InterceptionResult<int>> SavingChangesAsync(
            DbContextEventData eventData,
            InterceptionResult<int> result,
            CancellationToken cancellationToken = default)
        {
            foreach (var entry in eventData.Context.ChangeTracker.Entries())
            {
                if (entry.State == EntityState.Added || entry.State == EntityState.Modified)
                {
                    Console.WriteLine($"Entity Type: {entry.Entity.GetType().Name}");
                    foreach (var property in entry.OriginalValues.Properties)
                    {
                        Console.WriteLine($" - {property.Name}: {entry.OriginalValues[property]} => {entry.CurrentValues[property]}");
                    }
                }
            }

            return base.SavingChangesAsync(eventData, result, cancellationToken);
        }
    }

}
