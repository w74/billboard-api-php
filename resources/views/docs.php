<!DOCTYPE html>
<html>
<head>
  <title>Billboard API</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css?family=Gudea:400,700|Ubuntu+Mono" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/unsemantic/1.1.3/unsemantic-grid-responsive-tablet-no-ie7.min.css">
  <link rel="stylesheet" href="/docs.css">
</head>
<body>

  <section class="grid-container">
    <h1 class="grid-100">(Unofficial) Billboard API</h1>
    <h3 class="grid-100">Endpoints Reference</h3>
    <ul class="grid-100">
      <li><a href="">Album or Song Rankings for a particular week</a></li>
      <li><a href="">Albums or Songs at a particular ranking during a period of time</a></li>
      <li><a href="">Album &amp; Song Rankings associated with an Artist</a></li>
      <li><a href="">Historical information on a single Album or Song</a></li>
      <li><a href="">Search Database for an Artist, Album or Song</a></li>
    </ul>
  </section>


  <section class="grid-container">
    <h3 class="grid-100">Album or Song Rankings</h3>
    <p class="grid-60">Get the ranked albums or songs for a specific date. Dates should be in the format of <b>YYYY-MM-DD with no leading zeros</b>. Album rankings go from 1 to 200 and Song rankings go from 1 to 100. Album rankings go back as far as 1963-8-24, and Song rankings go back as far as 1958-8-9.</p>
  </section>
  <div class="grid-container">
    <div class="grid-50">
      <h6>Sample GET Request</h6>
      <div class="codeblock">
        <code>http://billboard.modulo.site/charts/{date}?[query-params]
        
<samp>date:</samp> the date of any Saturday

optional query parameters: {
  <samp>filter:</samp>
    desc: only get album or song rankings
    accepts: 'album' or 'song'
  <samp>min:</samp>
    desc: only get entries rank 'min' (inclusive) and higher
    accept: int
    default: 1
  <samp>max:</samp>
    desc: only get entries rank 'max' (inclusive) and lower
    accept: int
  <samp>pithy:</samp>
    desc: if 1, only returns Album and Song IDs; otherwise,
          returns all Album and Song info
    accept: 0 or 1
    default: 0
}</code>
      </div>
    </div>
    <div class="grid-50">
      <h6>Sample GET Response</h6>
      <div class="codeblock">
        <code>GET http://billboard.modulo.site/charts/2011-1-1?max=1

{
  albums: [
    {
      rank: "1",
      album_id: "29129",
      album_name: "Speak Now",
      artist_id: "371422",
      display_artist: "Taylor Swift",
      spotify_id: "5MfAxS5zz8MlfROjGQVXhy"
    }
  ],
  songs: [
    {
      rank: "1",
      song_id: "24797",
      song_name: "Firework",
      artist_id: "305595",
      display_artist: "Katy Perry",
      spotify_id: "4lCv7b86sLynZbXhfScfm2"
    }
  ]
}</code>
      </div>
    </div>
  </div>


  <section class="grid-container">
    <h3 class="grid-100">Ranking History for Albums or Songs</h3>
    <p class="grid-60">Get all albums or songs that were ranked at a specific position. Album rankings go from 1 to 200 and Song rankings go from 1 to 100. Use the 'from' and 'to' query parameters to specify the range of dates to return.</p>
  </section>
  <div class="grid-container">
    <div class="grid-50">
      <h6>Sample GET Request</h6>
      <div class="codeblock">
        <code>http://billboard.modulo.site/rank/{filter}/{num}?[query-params]
        
<samp>filter:</samp> either 'album' or 'song'
<samp>num:</samp> a ranking number

optional query parameters: {
  <samp>from:</samp>
    desc: only entries after date 'from' (inclusive)
    accepts: date (format of YYYY-MM-DD with no leading zeros)
  <samp>to:</samp>
    desc: only entries before date 'to' (inclusive)
    accepts: date (format of YYYY-MM-DD with no leading zeros)
  <samp>pithy:</samp>
    desc: if 1, only returns Album and Song IDs; otherwise,
          returns all Album and Song info
    accept: 0 or 1
    default: 0
}</code>
      </div>
    </div>
    <div class="grid-50">
      <h6>Sample GET Response</h6>
      <div class="codeblock">
        <code>GET http://billboard.modulo.site/rank/album/3?from=1984-6-23&amp;to=1984-6-30
          
[
  {
    date: "1984-06-30",
    album_id: "11601",
    album_name: "Born In The U.S.A.",
    artist_id: "298448",
    display_artist: "Bruce Springsteen",
    spotify_id: "0PMasrHdpaoIRuHuhHp72O"
  },
  {
    date: "1984-06-23",
    album_id: "11316",
    album_name: "Can't Slow Down",
    artist_id: "307447",
    display_artist: "Lionel Richie",
    spotify_id: "609oTPBaxPzZUCHzQikOtC"
  }
]</code>
      </div>
    </div>
  </div>


  <section class="grid-container">
    <h3 class="grid-100">Artist's Album &amp; Song History</h3>
    <p class="grid-60">Get an artists's ranked discography. By default, returns all Albums and Songs. Also includes <b>aggregate data</b>: the highest rank each entry has attained and the total number of weeks said entry was ranked. Use the 'from' and 'to' query parameters to specify the range of dates the results will reference.</p>
  </section>
  <div class="grid-container">
    <div class="grid-50">
      <h6>Sample GET Request</h6>
      <div class="codeblock">
        <code>http://billboard.modulo.site/artist/{id}?[query-params]
        
<samp>id:</samp> an artist's unique ID number

optional query parameters: {
  <samp>filter:</samp>
    desc: only get album or song information
    accepts: 'album' or 'song'
  <samp>from:</samp>
    desc: only entries after date 'from' (inclusive)
    accepts: date (format of YYYY-MM-DD with no leading zeros)
  <samp>to:</samp>
    desc: only entries before date 'to' (inclusive)
    accepts: date (format of YYYY-MM-DD with no leading zeros)
  <samp>pithy:</samp>
    desc: if 1, only returns Album and Song info, no aggregates
    accept: 0 or 1
    default: 0
}</code>
      </div>
    </div>
    <div class="grid-50">
      <h6>Sample GET Response</h6>
      <div class="codeblock">
        <code>GET http://billboard.modulo.site/artist/1493192?filter=album

{
  name: "G-Eazy",
  albums: [
    {
      album_id: "101",
      album_name: "These Things Happen",
      spotify_id: "6wDc63NhKy2PyXdbhkRmrl",
      highest_rank: "3",
      weeks_on_chart: "105"
    },
    {
      album_id": "29",
      album_name: "When It's Dark Out",
      spotify_id: "09Q3WwGYsQe5ognkvVkmCu",
      highest_rank: "5",
      weeks_on_chart: "32"
    }
  ]
}</code>
      </div>
    </div>
  </div>


  <section class="grid-container">
    <h3 class="grid-100">Album's or Song's Rank History</h3>
    <p class="grid-60">Get an Album's or Song's ranking history over time. Returns each week the entry is ranked as well as it's ranking position. Album rankings go from 1 to 200 and Song rankings go from 1 to 100. Use the 'from' and 'to' query parameters to specify the range of dates the results will reference.</p>
  </section>
  <div class="grid-container">
    <div class="grid-50">
      <h6>Sample GET Request</h6>
      <div class="codeblock">
        <code>http://billboard.modulo.site/music/{filter}/{id}

<samp>filter:</samp> either 'album' or 'song'
<samp>id:</samp> an Album's or Song's unique ID number

optional query parameters: {
  <samp>from:</samp>
    desc: only entries after date 'from' (inclusive)
    accepts: date (format of YYYY-MM-DD with no leading zeros)
  <samp>to:</samp>
    desc: only entries before date 'to' (inclusive)
    accepts: date (format of YYYY-MM-DD with no leading zeros)
  <samp>min:</samp>
    desc: only get dates ranked 'min' (inclusive) and higher
    accept: int
    default: 1
  <samp>max:</samp>
    desc: only get dates rank 'max' (inclusive) and lower
    accept: int
}</code>
      </div>
    </div>
    <div class="grid-50">
      <h6>Sample GET Response</h6>
      <div class="codeblock">
        <code>GET http://billboard.modulo.site/music/song/10150?from=1974-3-30&amp;to=1974-4-13

{
  song: {
    song_id: "10150",
    song_name: "Bennie And The Jets",
    artist_id: "301679",
    display_artist: "Elton John",
    spotify_id: "0LHzd11GIXVmND7TfQnGiy"
  },
  rankings: [
    {
      date: "1974-03-30",
      rank: "4"
    },
    {
      date: "1974-04-06",
      rank: "2"
    },
    {
      date: "1974-04-13",
      rank: "1"
    }
  ]
}</code>
      </div>
    </div>
  </div>


  <section class="grid-container">
    <h3 class="grid-100">Search Database</h3>
    <p class="grid-60">Search the database for an Album, Artist, or Artist. The search is case insensitive, and forgiving on extra whitespace. However, spelling is important as the search is not fuzzy.</p>
  </section>
  <div class="grid-container">
    <div class="grid-50">
      <h6>Sample GET Request</h6>
      <div class="codeblock">
        <code>http://billboard.modulo.site/search/{category}?q=...

<samp>category:</samp> either 'album', 'song', or 'artist'

required query parameters: {
  <samp>q:</samp>
    desc: the query to search for, case insensitive
    accepts: string
}

optional query parameters: {
  <samp>exact:</samp>
    desc: if 1, only returns results that exactly matches the search, case insensitive
    accept: 0 or 1
    default: 0
}</code>
      </div>
    </div>
    <div class="grid-50">
      <h6>Sample GET Response</h6>
      <div class="codeblock">
        <code>GET http://billboard.modulo.site/search/artist?q=kanye

[
  {
    artist_id: "276709",
    artist_name: "Kanye West"
  }
]</code>
      </div>
    </div>
  </div>

</body>
</html>