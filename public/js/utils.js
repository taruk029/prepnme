/* global Chart */

'use strict';

var barBackgroundColors = [ "rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)" ];

var doughnutBackgroundColors = ["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)"];

var barBorderColors = [ "rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)" ];

var labels_dev = [ "SoD", "C", "SoWB", "SoG", "R", "BE/R" ];

var labels_sup = [ "Sum of Supply", "Count of Resources", "Billed Effort/Resources" ];

Chart.plugins.register({
	afterDatasetsDraw: function(chart, easing) {
		// To only draw at the end of animation, check for easing === 1
		var ctx = chart.ctx;
		chart.data.datasets.forEach(function (dataset, i) {
			var meta = chart.getDatasetMeta(i);
			if (!meta.hidden) {
				meta.data.forEach(function(element, index) {
					// Draw the text in black, with the specified font
					ctx.fillStyle = 'rgb(0, 0, 0)';
					var fontSize = 12;
					var fontStyle = 'normal';
					var fontFamily = 'Helvetica Neue';
					ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
					// Just naively convert to string for now
					var dataString = dataset.data[index].toString();
					// Make sure alignment settings are correct
					ctx.textAlign = 'center';
					ctx.textBaseline = 'middle';
					var padding = 0;
					var position = element.tooltipPosition();
					ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
				});
			}
		});
	}
});