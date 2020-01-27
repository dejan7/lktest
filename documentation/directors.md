## <code>/directors</code> [/directors]

### Search for items [GET]
##### Available includes: [movies]
##### Available parameters <a href="#header-filters">See more...</a>
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Director, Director])

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->
### Create item [POST]
Available includes: [movies]
+ Request Rules:
    {
            "firstname": 'required',
            "lastname": 'required',
            "dob": 'nullable|date',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "firstname": et (string),
            "lastname": officia (string),
            "dob": 2019-12-26 (string),

    }
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Director successfully created (string)
        + data: (Director)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## <code>/directors/bulk</code> [/directors/bulk]
### Bulk create items [POST]
Available includes: [movies]
+ Request Rules:
    [
        {
            "firstname": 'required',
            "lastname": 'required',
            "dob": 'nullable|date',

        },
        {
            "firstname": 'required',
            "lastname": 'required',
            "dob": 'nullable|date',

        },
    ]
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    [
        {
            "firstname": quae (string),
            "lastname": quia (string),
            "dob": 2019-11-23 (string),

        },
        {
            "firstname": quae (string),
            "lastname": quia (string),
            "dob": 2019-11-23 (string),

        },
    ]
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Group of Directors successfully created (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Bulk delete items [DELETE]
+ Request (application/json)
    <!-- include(request/header.md) -->    
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Group of Directors successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->

## <code>/directors/{id}</code> [/directors/{id}]
### Update item [PUT]
Available includes: [movies]
<!-- include(parameters/id.md) -->
+ Request Rules:
    {
            "firstname": 'required',
            "lastname": 'required',
            "dob": 'nullable|date',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "firstname": quasi (string),
            "lastname": minima (string),
            "dob": 2019-12-05 (string),

    }
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Director successfully updated (string)
        + data: (Director)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Get single item [GET]
Available includes: [movies]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (Director)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->
### Delete item [DELETE]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->    
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Director successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->


## <code>/directors/{id}/movies</code> [/directors/{id}/movies]
### Search for movies [GET]
##### Available includes: [actors, directors, favoritedUsers, wishlistedUsers]
##### Available parameters <a href="#header-filters">See more...</a>
+ Parameters


    + id: 1 (number)
+ Request (application/json)
    <!-- include(request/header.md) -->


<!-- include(response/401.md) -->
<!-- include(response/500.md) -->

## <code>/directors/{id}/movies/{movie_id}</code> [/directors/{id}/movies/{movie_id}]
### Add Movie to movies [POST]
+ Parameters


    + id: 1 (number)
    + movie_id: 1 (number)
+ Request Rules:
    {

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {

    }


<!-- include(response/401.md) -->
<!-- include(response/500.md) -->

### Remove Movie from movies [DELETE]
+ Parameters


    + id: 1 (number)
    + movie_id: 1 (number)
+ Request (application/json)
    <!-- include(request/header.md) -->


<!-- include(response/401.md) -->
<!-- include(response/500.md) -->

