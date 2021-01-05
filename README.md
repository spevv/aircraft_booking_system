TODO 
- API test
- add documentation
- format code



The project is not finished. I spent 8 hours on this project.

Time:
- Preparation and TODO list - 30 minutes
- Preparation DB structure - 30 minutes
- Set up Laravel and libraries - 30 minutes
- Set up Codeception and API - 1 hour
- Code: SeatsController, SeatsBookingRequest, SeatsBookingResource - 30 minutes
- Code: migrations, models, factories - 1 hour
- Test and debugging - 30 minutes
- BookingService logic - 1 hour 30 minutes
- Documentation - 1 hour

The idea of implementation
First, build the overall structure of the project, and only then move on to the basic logic (booking).

Create a separate service (BookingService) through which the interaction with the code will go through the interface so that this service does not depend on the type of aircraft.
I did not implement the main logic of booking seats and did not come up with a good implementation in such a short time.
But to solve such problems, the Genetic Algorithm would be suitable.

In general, the system does not store the structure of the aircraft seats (schema), save only the reservations (bookings) themselves, this will not be tied to a particular aircraft and in the future to expand to other types of aircraft, using only records of aircraft characteristics in the database.

I use this structure of route `/flights/{flight}/seats/booking`, but I don't use {flight}.

What was done:
- DB structure
- request, resource
- structure for API tests

What did not have time to implement
- seat reservations
- unit tests (which could be described on the booking functionality without being tied to the data)



Time:
- Preparation and TODO list - 30 minutes
- Preparation DB structure - 30 minutes
- Set up Laravel and libraries - 30 minutes
- Set up Codeception and API - 1 hour
- Code: SeatsController, SeatsBookingRequest, SeatsBookingResource - 30 minutes
- Code: migrations, models, factories - 1 hour
- Test and debugging - 30 minutes
- BookingService logic - 1 hour 30 minutes
- Documentation - 1 hour





Some useful commands:

I use simple Laravel example (https://laravel.com/docs/8.x/sail)

Run docker containers from project folder
`docker-compose run`

Install dependencies
`php composer install`

Copy .env file
`cp .env.example .env`

Docker container for test app
`docker-compose exec laravel.test bash`


Сommand to run API tests
`php ./vendor/bin/codecept run api`


I hope that my code and approach will be clear how I wanted to solve the problem.
I also hope that we will still have a call so that I can better explain my ideas.
Unfortunately, I can't spend more time on this code to improve this code.
