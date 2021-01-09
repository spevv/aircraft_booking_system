###API
APIs structure of the route looks like this `/api/v1/flights/{flight_id}/seats/booking`

`flight_id` - id of flight, if flight_id exists it will use data from this flight, if it doesn't exist it will create a new one using this new id.
Existing flights will use data about booking from the DB.

`/api` - because this only applies to API requests
`/api/v1` - version of queries
`/api/v1/flights` - the ability to work with flight data, such as getting a flight list (`GET /api/v1/flights`, create new `POST /api/v1/flights`)
`/api/v1/flights/{flight_id}` - the ability to work with specific flight (`GET /api/v1/flights/1`)
`/api/v1/flights/{flight_id}/seats` - get seats structure (schema), data about reserved, free and all seats (`GET /api/v1/flights/{flight_id}/seats?type=all|reserved|free`)


###Time (14 hours)
- preparation and TODO list - 30 minutes
- preparation DB structure - 30 minutes
- set up Laravel and libraries - 30 minutes
- set up Codeception and API - 1 hour
- code: SeatsController, SeatsBookingRequest, SeatsBookingResource - 30 minutes
- code: migrations, models, factories - 1 hour
- test and debugging - 30 minutes
- BookingService logic - 4 hours
- documentation - 2 hours
- API tests - 1 hour 30 minutes

###The steps of implementation
- build the overall structure of the project (API skeleton), and only then move on to the basic logic (booking service);
- create API structure of the route which can be extendable;
- use API test for implementation requests. Also, generate random fake data.
- create a separate service (BookingService), register BookingService as Provider and interact with the interface so that this service does not depend on the type of aircraft (data) and return suitable seats.


###Some useful commands
- install dependencies `php composer install`
- start docker containers `./vendor/bin/sail up` (https://laravel.com/docs/8.x/sail)
- copy .env file `cp .env.example .env`
- run docker containers from project folder `docker-compose run` (https://docs.docker.com/compose/reference/)
- docker container for test app `docker-compose exec laravel.test bash`
- run API tests `php ./vendor/bin/codecept run api` (https://codeception.com/for/laravel)


###Additional information
I implemented the main logic just for 1-2 seats, however you can see the simplest code structure. For solving this problem one of the solutions can be Genetic Algorithm.

In general, the system does not store the structure of the aircraft seats (schema), save only the reservations (bookings) themselves, this will not be tied to a particular aircraft and in the future to expand to other types of aircraft, using only records of aircraft characteristics in the database.
In the future you can easily change the service to another that will have a different implementation.

I hope that my code and approach will be clear how I wanted to solve the problem. I didn't use Unit tests and API tests because of a lack of time. I also hope that we will still have a call so that I can better explain my ideas. Unfortunately, I can't spend more time on this code to improve this code. I am a bad person for proof of concept, but a good person for long term projects with a big structure and difficult logic.
