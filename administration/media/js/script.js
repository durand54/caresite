/* Author:
// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2011 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------------------------------------------
// Basic set. Feel free to add more tags
// ----------------------------------------------------------------------------
*/
var mySettings = {
	onShiftEnter:  	{keepDefault:false, replaceWith:'<br />\n'},
	onCtrlEnter:  	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>'},
	onTab:    		{keepDefault:false, replaceWith:'    '},
	previewTemplatePath: 'template/preview.html',
	markupSet:  [ 	
		{name:'Bold', key:'B', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
		{name:'Italic', key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)'  },
		{name:'Stroke through', key:'S', openWith:'<del>', closeWith:'</del>' },
/*		{name:'Paragraph', openWith:'<p(!( class="[![Class]!]")!)>', closeWith:'</p>' },*/
		{name:'Paragraph', openWith:"<p class='specificationsBox6Text'>", closeWith:'</p>' },
		{separator:'---------------' },
		{name:'Bulleted List', openWith:'    <li  class="poKeyPointText">', closeWith:'</li>', multiline:true, openBlockWith:"<ul>\n", closeBlockWith:'\n</ul>'},
		{name:'Numeric List', openWith:'    <li class="poKeyPointText">', closeWith:'</li>', multiline:true, openBlockWith:'<ol>\n', closeBlockWith:'\n</ol>'},
		{separator:'---------------' },
		{name:'Date of the Day', 
			className:"dateoftheday", 
			replaceWith:function(h) { 
				var date = new Date(),
					weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
					monthname = ["January","February","March","April","May","June","July","August","September","October","November","December"],
					D = weekday[date.getDay()],
					d = date.getDate(),
					m = monthname[date.getMonth()],
					y = date.getFullYear(),
					h = date.getHours(),
					i = date.getMinutes(),
					s = date.getSeconds();
				return (D +" "+ d + " " + m + " " + y + " " + h + ":" + i + ":" + s);
			}
		},
		{separator:'---------------' },
		{name:'Text indent', openWith:'<p class="specificationsBoxText" style="text-indent:20px;">',closeWith:'</p>'},
		{name:'Bold Red', className: "boldRed", openWith:"<p class='specificationsBox6Text'style='color:#FF0000; font-weight:700;'>", closeWith:'</p>' },
		{name:'Bold Green', className: "boldGreen", openWith:"<p class='specificationsBox6Text'style='color:#23ca39; font-weight:700;'>", closeWith:'</p>' },
		{name:'small', className: "smallFont", openWith:"<p class='specificationsBox6Text'style='color:#999999;font-size:6px;font-style: italic;'>", closeWith:'</p>' },
		{separator:'---------------' },
		{name:'Clean', className:'clean', replaceWith:function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },		
		{name:'Preview', className:'preview',  call:'preview'}
		
	]
}

$(".markItUp").markItUp(mySettings);




