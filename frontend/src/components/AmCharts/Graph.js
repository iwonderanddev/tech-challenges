import React, { Component } from 'react';

import 'amcharts3';
import 'amcharts3/amcharts/serial';
import 'amcharts3/amcharts/themes/light';

import AmCharts from "@amcharts/amcharts3-react";

// Generate random data
function generateData() {
  var firstDate = new Date();

  var dataProvider = [];

  for (var i = 0; i < 100; ++i) {
    var date = new Date(firstDate.getTime());

    date.setDate(i);

    dataProvider.push({
      date: date,
      value: Math.floor(Math.random() * 100)
    });
  }

  return dataProvider;
}


// Component which contains the dynamic state for the chart
class Graph extends Component {
  constructor(props) {
    super(props);

    this.state = {
      dataProvider: generateData(),
      timer: null
    };
  }

  componentDidMount() {
  }

  componentWillUnmount() {
    clearInterval(this.state.timer);
  }

  render() {
    const {axis, title, data} = this.props
    const config = {
	"type": "serial",
	"categoryField": "name",
	"startDuration": 1,
	"categoryAxis": {
		"gridPosition": "start"
	},
	"chartCursor": {
		"enabled": true
	},
	"chartScrollbar": {
		"enabled": true
	},
	"trendLines": [],
	"graphs": [
		{
			"fillAlphas": 1,
			"id": "AmGraph-1",
			"title": "graph 1",
			"type": "column",
			"valueField": "value"
		}
	],
	"guides": [],
	"valueAxes": [
		{
			"id": "ValueAxis-1",
			"zeroGridAlpha": -2,
			"gridCount": 1,
			"title": axis,
			"titleRotation": -4
		}
	],
	"allLabels": [],
	"balloon": {},
	"titles": [
		{
			"id": "Title-1",
			"size": 15,
			"text": title
		}
	],
	"dataProvider": data
};

    return (
      <div className="Graph">
        <AmCharts.React style={{ width: "100%", height: "500px" }} options={config} />
      </div>
    );
  }
}

export default Graph;
