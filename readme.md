# Unofficial Billboard API
## Index
1. API Endpoint Reference
	1. Get both Album/Song Rankings of a particular week
	2. Rankings
		* Get Ranking history for Albums
		* Get Ranking history for Songs
	3. Details
		* Get historical Album & Song Rankings associated with an Artist
		* Get historical information on a single Album
		* Get historical information on a single Song
	4. Search
		* Search Database for term
2. About
3. Legalities

## API Endpoint Reference
### Get both Album and/or Song Rankings
##### Endpoint:
`GET http://billboard.modulo.site/charts/{date}`
##### Request Parameters:
**date:** a specific day in YYYY-MM-DD format
##### Query Parameters:
```
Param	| Value									| Range/Default
filter	| Only show either Albums or songs		| 'album' or 'song'
min		| Lower bound (inclusive) for Ranking	| >= 1
max		| Upper bound (inclusive) for Ranking	| Albums: <= 200
												| Songs: <= 100
pithy	| Depth of detail provided.
		  1: only return Album or Song IDs
		  0: return all Album or Song info	| Default: False
```
---
### Get Ranking History for Albums
##### Endpoint:
`GET http://billboard.modulo.site/rank/album/{num}`
##### Request Parameters:
**num:** a Ranking position between 1 and 200
##### Optional Query Parameters:
```
Param	| Value									| Range/Default
from	| Specify Date to begin search			| N/A
to		| Specify Date to stop search			| N/A
pithy	| Depth of detail provided.
		  1: only return Album or Song IDs
		  0: return all Album or Song info		| Default: 0
```
---
### Get Ranking History for Songs
##### Endpoint:
`GET http://billboard.modulo.site/rank/song/{num}`
##### Request Parameters:
**num:** a Ranking position between 1 and 100
##### Optional Query Parameters:
```
Param	| Value									| Range/Default
from	| Specify Date to begin search			| N/A
to		| Specify Date to stop search			| N/A
pithy	| Depth of detail provided.
		  1: only return Album or Song IDs
		  0: return all Album or Song info		| Default: 0
```
---
### Get an Artist's Album & Song History
##### Endpoint:
`GET http://billboard.modulo.site/artist/{id}`
##### Request Parameters:
**id:** an Artist's unique ID
##### Optional Query Parameters:
```
Param	| Value									| Range/Default
from	| Specify Date to begin search			| N/A
to		| Specify Date to stop search			| N/A
filter	| Only show either Albums or Songs		| 'album' or 'song'
pithy	| Depth of detail provided.
		  1: only return Album or Song IDs
		  0: return all Album or Song info	| Default: False
```
---
### Get Album History
##### Endpoint:
`GET http://billboard.modulo.site/music/album/{id}`
##### Request Parameters:
**id:** an Album's unique ID
##### Optional Query Parameters:
```
Param	| Value									| Range/Default
from	| Specify Date to begin search			| N/A
to		| Specify Date to stop search			| N/A
min		| Only show weeks where album/song was
		  ranked {min} or above					| >= 1
max		| Only show weeks where album/song was
		  ranked {max} or below					| <= 200
```
---
### Get Song History
##### Endpoint:
`GET http://billboard.modulo.site/music/song/{id}`
##### Request Parameters:
**id:** an Album's or Song's unique ID
##### Optional Query Parameters:
```
Param	| Value									| Range/Default
from	| Specify Date to begin search			| N/A
to		| Specify Date to stop search			| N/A
min		| Only show weeks where album/song was
		  ranked {min} or above					| >= 1
max		| Only show weeks where album/song was
		  ranked {max} or below					| <= 100
```
---
### Search Database
##### Endpoint:
`GET http://billboard.modulo.site/search/{category}?q=...`
##### Request Parameters:
**category:** either 'album', 'song', or 'artist' to search only for Albums, Songs, or Artists, respectively.
##### Required Query Parameters:
```
Param	| Value
q		| Term to search for (case insensitive unless exact is true)
```
##### Optional Query Parameters:
```
Param	| Value									| Range/Default'
exact	| 1: only return exact matches
		  0: return all similar matches			| Default: False
```


## About
This REST API delivers information from Billboard's website. The intention is to create an API that could deliver the same essential data as Billboard's site but on a more manageable scale. I have tried to (manually, and very time consumingly) comb through the data to fix any inconsistencies, but it is likely I missed a few. If you spot anything wrong, please [email me](wolfram.rong@gmail.com) with the Date, Song/Album name, and Rank Number.

## Legalities
Basically, I don't own any of this information so you can't use this API for commerical projects.