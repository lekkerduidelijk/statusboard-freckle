statusboard-freckle
===================

PHP script that fetches [Freckle](http://letsfreckle.com) time entries, for [Panic's StatusBoard](http://panic.com/statusboard) iPad app.


## Setup

* Get your [Freckle API token](http://help.letsfreckle.com/import-export-api/api)
* Set the <code>$token</code> and <code>$subdomain</code>
* Upload the file to your PHP-enabled webhost
* Add the graph to your StatusBoard
* Done!
 

## Sample output

If properly setup your output should look something like this.

<img src="https://raw.github.com/lekkerduidelijk/statusboard-freckle/master/screenshot.png">


```

{
  "graph" : {
    "title" : "Hours last week",
    "total" : true,
    "type"  : "bar",
    "refreshEveryNSeconds" : 1800,
    "yAxis" : {
      "units" : {
        "suffix" : "h"
      }
    },
    "datasequences" : [
      {
        "title" : "Freckle",
        "color" : "orange",
        "datapoints" : [
          {
            "title" : "Fri",
            "value" : 7.42,
          },
          {
            "title" : "Thu",
            "value" : 8.25,
          },
          {
            "title" : "Wed",
            "value" : 6.5,
          },
          {
            "title" : "Tue",
            "value" : 5.75,
          },
          {
            "title" : "Mon",
            "value" : 9.42,
          },
          {
            "title" : "Sun",
            "value" : 0.42,
          },
          {
            "title" : "Sat",
            "value" : 4.25,
          },
        ]
      }
    ]
  }
}
```

More info on available options, check the [Graph Tutorial (PDF)](http://www.panic.com/statusboard/docs/graph_tutorial.pdf).
