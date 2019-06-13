define({ "api": [
  {
    "type": "",
    "url": "/check_login",
    "title": "Check login",
    "description": "<p>The login status should be control by session</p>",
    "group": "System",
    "version": "0.0.0",
    "filename": "newblog/system/core/Controller.php",
    "groupTitle": "System",
    "name": "Check_login"
  },
  {
    "type": "post",
    "url": "/Welcome/check_userlist/:name/:pass",
    "title": "Get user list from mysql",
    "name": "CheckUserList",
    "group": "User",
    "parameter": {
      "fields": {
        "User": [
          {
            "group": "User",
            "optional": false,
            "field": "name",
            "description": ""
          },
          {
            "group": "User",
            "optional": false,
            "field": "pass",
            "description": ""
          }
        ]
      }
    },
    "description": "<p>Set session with user name, also create the setting file</p>",
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p>The user or password is wrong</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Bad_Request",
            "description": "<p>The user or password is wrong</p>"
          }
        ]
      }
    },
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
    "url": "/Welcome/signup_user/:name/:pass",
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
            "field": "name",
            "description": "<p>Username</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pass",
            "description": "<p>User Password</p>"
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
    "url": "/ReturnView/get_local_case/case/suite_year/suite_mon/suite_day/suite/suite_num/loop/user",
    "title": "Get case result",
    "name": "GetCaseDetail",
    "description": "<p>Return the local test case result on JSON, inline function :read_result()</p>",
    "group": "View",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "case",
            "description": "<p>Case name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "suite_year",
            "description": "<p>Year folder</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "suite_mon",
            "description": "<p>Mouth folder</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "suite_day",
            "description": "<p>Day folder</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "suite",
            "description": "<p>Suitename</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "suite_num",
            "description": "<p>Number inside Suite folder</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "loop",
            "description": "<p>loop number</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user",
            "description": "<p>User name</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "list",
            "description": "<p>type/desc/info/details/status/time</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "type",
            "description": "<p>String of type, tell the type of result</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "desc",
            "description": "<p>String of the description, depend on sipp</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "info",
            "description": "<p>String of the infomation, depend on sipp</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "details",
            "description": "<p>String of the details, depend on sipp</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "status",
            "description": "<p>String of the status, OKAY/WARNING/FAILED</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "time",
            "description": "<p>String of the timestamp</p>"
          },
          {
            "group": "Success 200",
            "type": "boolen",
            "optional": false,
            "field": "response",
            "description": "<p>Read file: success or failed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\tHTTP/1.1 200 OK \n {\n     \"list\":[\n         {\n             \"type\":\"Run\",\n             \"desc\":\"\",\n             \"info\":\"script ->  \\\"..\\/lib\\/initialize\\\" deviceList\",\n             \"details\":\"\",\n             \"status\":\"OKAY\",\n             \"time\":\"00:00:00:001\"\n         },{\n             \"type\":\"API\",\n             \"desc\":\"\",\n             \"info\":\"temp -> Init\",\n             \"details\":\"http:\\/\\/192.168.92.30\\/cgi-bin\\/api-request_init_phone_status?passcode=123456\",\n             \"status\":\"OKAY\",\n             \"time\":\"00:00:00:138\"\n         },{\n             \"type\":\"API\",\n             \"desc\":\"\",\n             \"info\":\"temp -> Init\",\n             \"details\":\"http:\\/\\/192.168.92.80\\/cgi-bin\\/api-request_init_phone_status?passcode=123456\",\n             \"status\":\"OKAY\",\n             \"time\":\"00:00:00:225\"\n         }\n     ],\n     \"response\": true\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "FileNotFound",
            "description": "<p>The case folder was not found</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"error\": \"FileNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.2",
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
          "content": "\tHTTP/1.1 200 OK \n\t{\n     \"list\": [\n\t\t    {\"failnum\":\"1\",\"totalnum\":\"2\",\"time\":\"1559786074\"},\n\t\t    {\"failnum\":\"0\",\"totalnum\":\"1\",\"time\":\"1559786715\"},\n\t\t    {\"failnum\":\"1\",\"totalnum\":\"1\",\"time\":\"1560158422\"},\n\t\t    {\"failnum\":\"1\",\"totalnum\":\"3\",\"time\":\"1560238799\"}\n     ]\n\t}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.1",
    "filename": "newblog/application/controllers/Welcome.php",
    "groupTitle": "View"
  },
  {
    "type": "get",
    "url": "/ReturnView/get_page_class/type/user/page/limit/rowtitle/order/:keyword",
    "title": "Get page",
    "name": "Getpagintor",
    "group": "View",
    "description": "<p>IT IS ROUTER PARAM</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>Test suite or Test case (ROUTER)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user",
            "description": "<p>User name (ROUTER)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>Page number (ROUTER)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "limit",
            "description": "<p>Number of cases for each page (ROUTER)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "rowtitle",
            "description": "<p>Row title on MySql table (ROUTER)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order",
            "description": "<p>Order the data by ASC or DESC (ROUTER)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "keyword",
            "description": "<p>Keyword to search on mysql (ROUTER)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n    /case/ylhe/1/10/name/0\n}",
          "type": "String"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>String of the case name</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "numc",
            "description": "<p>String of the number</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "loopc",
            "description": "<p>String of the loop number</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result",
            "description": "<p>String of the result</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "path",
            "description": "<p>String of the folder</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "time",
            "description": "<p>String of the time stamp hh:mm:ss:mms</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "date",
            "description": "<p>String of the date -unix</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "fail_res",
            "description": "<p>String of the failed reason</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "fail_act",
            "description": "<p>String of the failed action</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>String of the user name who run the test case</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\tHTTP/1.1 200 OK \n {\n     \"list\":[{\n         \"name\": \"Attend_transfer\",\n\t        \"numc\": \"1\",\n\t        \"loopc\": \"1\",\n\t        \"result\": \"FAILED\",\n\t        \"path\": \"..\\/History\\/ylhe\\/2019\\/05\\/09\\/suite_182854\\/\",\n\t        \"time\": \"00:00:54:958\",\n\t        \"date\": \"1557397789\",\n\t        \"fail_res\": \"test\",\n\t        \"fail_act\": \"trs\",\n\t        \"username\": \"ylhe\"\n     },{\n         \"name\": \"Attend_transfer\",\n\t        \"numc\": \"1\",\n\t        \"loopc\": \"2\",\n\t        \"result\": \"FAILED\",\n\t        \"path\": \"..\\/History\\/ylhe\\/2019\\/05\\/09\\/suite_182854\\/\",\n\t        \"time\": \"00:00:54:958\",\n\t        \"date\": \"1557397789\",\n\t        \"fail_res\": \"test\",\n\t        \"fail_act\": \"trs\",\n\t        \"username\": \"ylhe\"\n     }]\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ParameterNotFound",
            "description": "<p>The parameter was not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n \"error\":\"router parameter error\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.2",
    "filename": "newblog/application/controllers/ReturnView.php",
    "groupTitle": "View"
  }
] });
