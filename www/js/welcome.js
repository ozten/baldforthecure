$(document).ready(function(){
    var link = $('#blog-link').attr('href');
    var rssoutput = "<h3><a href='" + link + "'>Bald for the Cure blog</a></h3><ul>";

    function displayfeed(result){
        if (!result.error){
            var thefeeds=result.feed.entries
            for (var i=0; i<thefeeds.length; i++) {
                rssoutput += "<li><a href='" + thefeeds[i].link + "'>" + thefeeds[i].title +
                             "</a><div class='blog-entry'>" + thefeeds[i].contentSnippet + "</div></li>";                
            }
            rssoutput += "</ul>";            
            $('#feeddiv').append(rssoutput);
        } else {
            if (window.console) console.error("Cannot grab /blog feed");
        }
    }
    
    var feedpointer=new google.feeds.Feed("http://baldforthecure.com/blog/feed/");
    feedpointer.setNumEntries(5);
    feedpointer.load(displayfeed);
});
                  
