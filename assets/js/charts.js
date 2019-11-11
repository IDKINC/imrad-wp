/* start donut charts */
var donut = (function (one) {
    var chart = d3.select("#votesWith"),
    chartJ = jQuery('#votesWith'),
    withColor = chartJ.data('withcolor'),
    againstColor = chartJ.data('againstcolor');

    var width = 400,
        height = 400,
        radius = 200,
        colors = d3.scaleOrdinal()
            .range([withColor, againstColor]);
    var piedata = [{
        label: "Votes With Party",
        value: chartJ.data('with')
    }, {
        label: "Votes Against Party",
        value: chartJ.data('against')
    },];


    var pie = d3.pie()

        .value(function (d) {

            return d.value;

        })
    var arc = d3.arc()
        .innerRadius(radius - 100)
        .outerRadius(radius)

    var donutChart = chart.append('svg')
    .attr("preserveAspectRatio", "xMidYMid meet")
    .attr("viewBox", "0 0 " + width + " " + height)
        .append('g')
        .attr('transform', 'translate(' + (width - radius) + ',' + (height - radius) + ')')
        .selectAll('path').data(pie(piedata))
        .enter().append('g')
        .attr('class', 'slice')



    var slices1 = d3.selectAll('g.slice')
        .append('path')
        .attr('fill', function (d, range) {
            return colors(range);
        })
        .attr('d', arc)

})();