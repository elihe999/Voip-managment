define({ "api": [
  {
    "type": "",
    "url": "@apiDescription",
    "title": "The login status should be control by session",
    "group": "System",
    "version": "0.0.0",
    "filename": "newblog/system/core/Controller.php",
    "groupTitle": "System",
    "name": "Apidescription"
  },
  {
    "type": "get",
    "url": "/Welcome/check_userlist",
    "title": "Get user list from mysql",
    "name": "CheckUserList",
    "group": "User",
    "version": "0.0.1",
    "filename": "newblog/application/controllers/Welcome.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/FileControl/download/:folder",
    "title": "Download folder as Zip",
    "name": "Download_zip",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "folder",
            "description": "<p>Target result folder</p>"
          }
        ]
      }
    },
    "group": "User",
    "version": "0.0.1",
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TargetNotFound",
            "description": "<p>The target folder was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 404 Not Found\n {\"reason\":\"Not a folder\"}",
          "type": "json"
        }
      ]
    },
    "filename": "newblog/application/controllers/FileControl.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/Message/sendEmail",
    "title": "Send Email",
    "name": "SendEmail",
    "group": "User",
    "version": "0.0.1",
    "filename": "newblog/application/controllers/Message.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/Welcome/signup_user/:name/:password",
    "title": "Signup",
    "name": "signup",
    "description": "<p>Sign up new user if it is not exist</p>",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Username",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Userpassword",
            "description": ""
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "String[]",
            "optional": false,
            "field": "result",
            "description": "<p>Answer from server</p>"
          },
          {
            "group": "200",
            "type": "String[]",
            "optional": false,
            "field": "ask",
            "description": "<p>Answer from server</p>"
          }
        ]
      }
    },
    "filename": "newblog/application/controllers/Welcome.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/ReturnView/page_class/:type/:user/:page/:limit/:keyword/:order",
    "title": "Get fail chart",
    "name": "GetSimpleChart",
    "group": "View",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>Test suite or Test case</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user",
            "description": "<p>User name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>Page number</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keyword",
            "description": "<p>Keyword to search on mysql</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order",
            "description": "<p>Order the data</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "failnum",
            "description": "<p>String of the failed case number</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "totalnum",
            "description": "<p>String of the total case</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "time",
            "description": "<p>String of timestamp -unix</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n{\"list\":[\n\t{\"failnum\":\"1\",\"totalnum\":\"2\",\"time\":\"1559786074\"},\n\t{\"failnum\":\"0\",\"totalnum\":\"1\",\"time\":\"1559786715\"},\n\t{\"failnum\":\"1\",\"totalnum\":\"1\",\"time\":\"1560158422\"},\n\t{\"failnum\":\"1\",\"totalnum\":\"3\",\"time\":\"1560238799\"}]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.1",
    "filename": "newblog/application/controllers/ReturnView.php",
    "groupTitle": "View"
  },
  {
    "type": "get",
    "url": "/Welcome/simplechart",
    "title": "Get fail chart",
    "name": "GetSimpleChart",
    "group": "View",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "failnum",
            "description": "<p>String of the failed case number</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "totalnum",
            "description": "<p>String of the total case</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "time",
            "description": "<p>String of timestamp -unix</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n{\"list\":[\n\t{\"failnum\":\"1\",\"totalnum\":\"2\",\"time\":\"1559786074\"},\n\t{\"failnum\":\"0\",\"totalnum\":\"1\",\"time\":\"1559786715\"},\n\t{\"failnum\":\"1\",\"totalnum\":\"1\",\"time\":\"1560158422\"},\n\t{\"failnum\":\"1\",\"totalnum\":\"3\",\"time\":\"1560238799\"}]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.1",
    "filename": "newblog/application/controllers/Welcome.php",
    "groupTitle": "View"
  }
] });
