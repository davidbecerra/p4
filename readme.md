# Project 4
## CS S-15

By David Becerra

##Live URL
http://p4-dbecerra.rhcloud.com
##Description
This site is an online Pokedex. In other words, it is simply a search engine for Pokemon. A user can search for a particular Pokemon or search based on general constraints (e.g. all the Water type Pokemon).

##Details for instructor
I wanted to keep the homepage simple. So I only include a basic search for a specific Pokemon name. On the Pokemon page (linked to in the nav-bar), my idea was to provide a more extensive search in addition to the simple name search from the homepage. As of now, the advanced search only includes searching via Pokemon type. However, in the future, I would like to add a greater selection of query options under the advanced search. 

I also implemented user log in and authentication. Initially, I planed to have additional features for users. Specifically, I wanted to have users be able to favorite certain Pokemon, or even create their own teams. I will definitely consider adding this in the future. As of now, the user features are identical to non-users. However, certain pages are only accessible for guests (i.e. Log in and Sign up pages).

The hardest part was filling my database. I need lots of information for each Pokemon. Creating the script that scraped for the data took a long time. I had to parse through the source of several websites to determine which site organized their Pokemon data the best. In addition, I had to determine how I wanted to best store the data in my database. The scraper I wrote is located in `/app/scraper`.

The default user in the database is `test` with email address `test@user.com` and password `123456`.

##Outside code
* Query many-to-many table based on multiple constraints on related table: http://stackoverflow.com/questions/22298935/laravel-eloquent-orm-wherehas-and-where-in-foreach
* Website icon art: Elisabeth Meyer (friend and artist)
* Pokemon data and images: 
    - http://pokemondb.net
    - http://www.psypokes.com
* PHP HTML Dom Parser: https://github.com/sunra/php-simple-html-dom-parser