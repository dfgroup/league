# league
Drupal tournament managent module for Drupal
League Structure.

League is a series of modules and services defined for Drupal 8 to allow tournament management.

The basic API defines entities, content types and tables, unleashing Drupal 8 power to reveal a scalable, flexible and solid base for tournament management.

Modules

League

•	Basic definitions and defaults

•	Common functions

•	Installation profiles

o	Create basic person types

o	Create basic game type

o	Create basic content types

League_person

•	Define basic person entity

League_game

•	Define basic game enity

•	Define game views

•	Define the result logic. Result should be a complex field.

o	Extra time

o	Penalties

o	Other exeptions

o	Other sports

League_lineaup

•	Define lineup table

•	Define CRUD for lineups

•	Create UI to load game lineups

•	Define which information belongs to player and which to lineup. F.e. Player number

•	Create relationship with substitutions

League_minute

•	Créate minute table

•	Define CRUD for minute tables

•	Create Minute UI as a field for games.

•	Create AJAX logic. Angular.js

League_table

•	Define DB-table for game statistics

•	Define CRUD for game statistics table

•	Define services to convert game result into statistics

o	This will provide an API for each type of sport

League_table_alter

•	Define table alter logic

•	Define CRUD for table alter

•	Integrate alters to table calculations

League_event

•	Define basic event entity

•	Define system events

League_og

League_og_context

League_extras

League_services


