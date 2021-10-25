# Risk Profile

## How To Execute

### Docker

This project was structured to run the application with Docker, orchestrated via docker-compose.

Execute this commands to build an start the application using docker in port 8080:

```
make docker-build
make docker-start
```

### Locally

If you wish to run it locally, run this command and the application should start in port 8000:

```
make-start
```

## Testing

To run the tests execute:

```
make docker-test
```

Execute the following command to generate an html code coverage report. It will be generated in the `/reports` directory:

```
make docker-test-coverage
```


## How To Use

| Method   | Endpoint                                 | Description                              |
| -------- | ---------------------------------------- | ---------------------------------------- |
| `POST`   | `/api/v1/risk-profiles`                  | Create a Risk Profile.                   |

To create a risk profile, send a POST request to the risk-profiles endpoint with the user's information, like this example:

```
curl --location --request POST 'http://localhost:8080/api/v1/risk-profiles' \
--header 'Content-Type: application/json' \
--data-raw '{
    "age": 41,
    "dependents": 3,
    "income": 200001,
    "marital_status": "single",
    "risk_questions": [1, 1, 1],
    "vehicle": {
        "year": 2022
    },
    "house": {
        "ownership_status": "owned"
    }
}'
```

The application should respond with a JSON payload like the following:

```
{
    "auto": "responsible",
    "life": "responsible",
    "home": "responsible",
    "disability": "responsible"
}
```

## Technical Decisions

I opted for using a Chain of Responsibility Design Pattern to model the risk rules. Each RiskRuleHandler is a class that implements a method to validate if the User's Information fits in it. Each handler receives a reference for an operation that changes the risk score. This Operation, by the other hand, was modeled following the Strategy Design Pattern. An interface declares the execute method, and each class implements it differently.

These decisions made it possible, I think, to create a code that is, maybe a little bit too verbose, but also really easy to maintain and to add new features, like different rules or operations.

## Technologies

I opted for using the framework Lumen because it is small, fast and similar to Laravel (with which I have some familiarity), without all the clutter and dependencies. I've also used Docker to quickly build and start the application.