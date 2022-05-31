# Zap-Map Technical Challenge

This repo contains a Laravel app implementing an API for listing locations.

## Pre-requisites

* PHP 8
* MySQL

## Setup

1. Configure `.env` with the DB connection settings
1. Run DB migrations `php artisan migrate`
1. Seed DB with sample location data `php artisan db:seed --class=LocationSeeder`
1. Run app and make an HTTP request `GET http://localhost/api/v1/locations?latitude=n&longitude=n&radius=2`

## API format

The API has a single endpoint: `GET http://localhost/api/v1/locations`.

It accepts the following querystring parameters:

* `latitude`
* `longitude`
* `radius` (metres)

The endpoint will return a list of locations within the given radius, ordered by distance.

The response is a JSON object with the following structure:

```json
{
    "data": [
        {
            "id": 812,
            "name": "Asda Hereford",
            "position": {
                "type": "Point",
                "coordinates": [
                    -2.0610554621947,
                    52.088850856128
                ]
            },
            "created_at": "2022-05-31T12:07:13.000000Z",
            "updated_at": "2022-05-31T12:07:13.000000Z",
            "distance": 0
        },
        {
            "id": 862,
            "name": "Morrisons Stockport",
            "position": {
                "type": "Point",
                "coordinates": [
                    -2.0542724544982,
                    52.122946051418
                ]
            },
            "created_at": "2022-05-31T12:07:13.000000Z",
            "updated_at": "2022-05-31T12:07:13.000000Z",
            "distance": 3819.4024221423174
        }
    ],
    "total": 2
}
```

* The `position` property is the latitude and longitude of the location in GeoJSON format.
* The `distance` property is the distance in metres from the given latitude/longitude.

If the parameters fail validation, a `400 Bad Request` response will be returned with error messages.

## Database

The database is structured as follows:

* `id` - autoincrement ID
* `name` - name of the location
* `position` - latitude and longitude of the location, stored as a MySQL geospatial `POINT` type
* `created_at` and `updated_at` - timestamp columns

A `position` column is indexed with a spatial index.