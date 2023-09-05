// Store the URL into variable
var url = "https://geeksforgeeks.org/pathname/?search=query";
      
// Created a URL object using URL() method
var parser = new URL(url);
       
// Protocol used in URL
document.write(parser.protocol + "<br>");
       
// Host of the URL
document.write(parser.host + "<br>");
       
// Port in the URL
document.write(parser.port + "<br>");
       
// Hostname of the URL
document.write(parser.hostname + "<br>");
       
// Search in the URL
document.write(parser.search + "<br>");
       
// Search parameter in the URL
document.write(parser.searchParams + "<br>");
  