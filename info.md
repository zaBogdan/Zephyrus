# zaEngine

### Technologies used
- As the backend we will use a Python API, for user handling and content management. 
- For the web frontend we will use PHP with **Twig** framework, using a custom **Router** and **API Request** engine.
- For the mobile app we will use either React Native or Flutter. 

### The API
- Should handle both application, be RESTful and also should prioterize the requests.
- This should be pulled from github, checking it every day. 

##### Users endpoints
```C
    /users/<int:id> -> Returns information about a specific user [ Authentificated ]
    /users/auth -> Authentificates a user, responding with a token
    /users/register -> Registers a user, sending a confirmation email
    /users/update -> Updates some information about the user [ Likes, Comments, Notifications etc. ] [ Authentificated ]
```

##### Post endpoints 
```C
     [ All requests must be authentificated ]
/content/post/<int:id> -> Returns specific post information
/content/add -> Creates a new post 
/content/delete -> Deletes a post, 1 day delay
/content/upload -> Uploads a photo/Some media
```

##### Information
```C
/check -> Tests if it is web or mobile
/version -> Returns the version of the API
```

### The Web Application
- Should implement everything on the api, with a nice Design.
- The API Handler should be as reusable as possible, also, the **Users** and **Content** clases should create objects with witch we are supposed to work, reducing a lot of the code. 
- The Router class should handle all users requests with pretty urls and strong input checks, reusablitly is a must!
- The Admin side should be secured by the same API, which will give real time information about it's status and version. 

### The Mobile Application
###### TO BE DONE. 

### Bugs to be solved
###### TO BE DONE
