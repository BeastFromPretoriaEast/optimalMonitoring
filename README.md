# OML - Interview task

# Description

Your task is to create a simple Laravel application that allows to plot a graph of utility consumption for your customer.

They need to be able to customize graph parameters: select meters from a list, pick date period (start and end date), and input a flat benchmark value.
Then, they will want to be able to plot a graph according to those parameters.
The graph should be a line graph where each line represents a meter's consumption data over time.
The benchmark value should be a flat, horizontal line on the graph.

Also, customer wants to be able to display this graph on a standalone page - they will want to display it on a screen in lobby,
creating greater awareness of how you are using and wasting utilities within their business to be more utility efficient.

# You will have to create database tables for your two main entities:

- Meters:
  Represents an electricity meter owned by customer.
  Meter has name, some serial number and basic timestamps (creation date, updated at, etc.).

- Consumption data:
  Represents a value of consumption in the last 30 minutes.
  This is in half-hourly format and BELONGS to a meter.
  Consumption data record should have a reference to its meter, a timestamp and a value.

# Stack requirements

- Implement your application using Laravel framework
- Use SQLite as a database engine
- Use any CSS framework (e.g. Bootstrap) to make application prettier
- Use charting library of choice

# Tasks

- Prepare database:

  - Create a database migrations for your entities: meters, consumption_data
  - Create a database seeder for meters (5-20 records)
  - Create a database seeder for consumption data (48-1440 records for each meter, 48 values represent a day of consumption history)
  - Migrate and seed the database

- Implement the 'Create a graph' functionality

  - Implement the 'Create a graph' view according to the wireframe
  - The view should include a form that lets you to customize the Graph:
    - Meters - select from a list
    - Period - start and end date. End date should be an optional parameter
    - Benchmark value - flat consumption value, drawn as a horizontal line on the graph
  - The view should allow users to generate graph on the screen according to the parameters outlined above
  - After the graph is generated, display a link to standalone version of it ('Graph display' task below)

- Implement the 'Graph display' functionality
  - Implement the 'Graph display' view according to the wireframe
  - This view should present a graph that is plotted according to a set of parameters
  - Graph should take up full width and height of the viewport so that it can be displayed on a screen in customer's lobby area

# Submission

Please organize, design, and document your code as if it were
going into production - then push your changes to the master branch.
After you have pushed your code, you may submit the assignment on the assignment page.

All the best and happy coding,
