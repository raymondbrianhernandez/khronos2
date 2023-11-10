namespace PublicTalk_Manager.Model
{
    public class Outgoing
    {
        public int Id { get; set; }
        public int Year { get; set; }
        public DateTime Date { get; set; }
        public string? Congregation_From { get; set; }

        public string? Congregation_To1 { get; set; }
        public string? Speaker1 { get; set; }
        public string? Title1 { get; set; }
        public string? PT_Overseer1 { get; set; }
        public string? Note1 { get; set; }

        public string? Congregation_To2 { get; set; }
        public string? Speaker2 { get; set; }
        public string? Title2 { get; set; }
        public string? PT_Overseer2 { get; set; }
        public string? Note2 { get; set; }

        public string? Congregation_To3 { get; set; }
        public string? Speaker3 { get; set; }
        public string? Title3 { get; set; }
        public string? PT_Overseer3 { get; set; }
        public string? Note3 { get; set; }

        public string? Congregation_To4{ get; set; }
        public string? Speaker4 { get; set; }
        public string? Title4 { get; set; }
        public string? PT_Overseer4 { get; set; }
        public string? Note4 { get; set; }
    }
}
