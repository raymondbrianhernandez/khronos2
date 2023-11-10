namespace PublicTalk_Manager.Model
{
    public class History
    {
        public int Id { get; set; }
        public string? Congregation_Owner { get; set; }
        public DateTime Date { get; set; }
        public string? Name { get; set; }
        public string? Congregation { get; set; }
        public int? Outline_No { get; set; }
    }
}
