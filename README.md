# airport-data-entry
a project on airport data entry and flight data entry. It is created on php, and mysql.


It allows to add flight details for airport in such a way that only one flight arrives
or departs from airport at a particular time with 10 minutes of runway time. To achieve
this, you should have a database schema/collection with airport details as below:
    
    - id
    - airport_code (varchar 6)
    - airport_name (varchar 255)

and schema/collection for Flight Schedule as below:
    
    -   id
    -  from_airport_id
    -  to_airport_id
    -  flight_no (varchar 10)
    -  depart_time
    -  arrival_time
    
For Example, let’s consider a snapshot of Flight Schedule as below:

     Record 1 {
        'id':'XYZVGHB",
        'from_airport_id":1, (FOR Bangalore)
        'to_airport_id":2, (FOR Delhi),
        'flight_no':'FL-ABC',
        'depart_time':'14:00',
        'arrival_time':'16:30'
    }

    Record 2 {
        'id':'XYZVGHB",
        'from_airport_id":2, (FOR Delhi)
        'to_airport_id":3, (FOR Mumbai),
        'flight_no':'FL-MUI',
        'depart_time':'13:45',
        'arrival_time':'15:15'
    }
If the user tries to add Flight Schedule for flight from/to Delhi, then arrival/depart
time should not be between 1. 16:20 to 16.40, 2. 13:35 to 13:55. And if input from lies
b/w above times, it should throw an error to the user for conflict timing along with
details of flight which is conflicting.



