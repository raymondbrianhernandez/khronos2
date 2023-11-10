namespace PublicTalk_Manager.Model
{
    public class Schedule
    {
        public int Id { get; set; }
        public int Year { get; set; }
        public DateTime Date { get; set; }
        public string? Congregation_To { get; set; }
        public string? Congregation_From { get; set; }
        public string? Speaker { get; set; }
        public string? Privilege { get; set; }
        public string? Title { get; set; }
        public string? Outline { get; set; }
        public int Song { get; set; }
        public string? Chairman { get; set; }
        public string? Note { get; set; }
    }
}
