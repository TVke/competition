var possible=['/img/fotos.jpg','/img/gebruik.jpg','/img/iphone.jpg','/img/mensen.jpg'];
var koala={version:'1.8.2'};
(function(window,undefined){
	function array2d(w,h){
		var a=[];
		return function(x,y,v){
			if(x<0||y<0)return void 0;
			if(arguments.length===3){
				return a[w*x+y]=v;
			}
			else if(arguments.length===2){
				return a[w*x+y];
			}
			else{
				throw new TypeError("Bad number of arguments");
			}
		};
	}
	function avgColor(x,y,z,w){
		return[(x[0]+y[0]+z[0]+w[0])/4,(x[1]+y[1]+z[1]+w[1])/4,(x[2]+y[2]+z[2]+w[2])/4];
	}
	koala.supportsCanvas=function(){
		var elem=document.createElement('canvas');
		return!!(elem.getContext&&elem.getContext('2d'));
	};
	koala.supportsSVG=function(){
		return!!document.createElementNS&&!!document.createElementNS('http://www.w3.org/2000/svg',"svg").createSVGRect;
	};
	function Circle(vis,xi,yi,size,color,children,layer,onSplit){
		this.vis=vis;
		this.x=size*(xi+0.5);
		this.y=size*(yi+0.5);
		this.size=size;
		this.color=color;
		this.rgb=d3.rgb(color[0],color[1],color[2]);
		this.children=children;
		this.layer=layer;
		this.onSplit=onSplit;
	}
	Circle.prototype.isSplitable=function(){
		return this.node&&this.children;
	};
	Circle.prototype.split=function(){
		if(!this.isSplitable())return;
		d3.select(this.node).remove();
		delete this.node;
		Circle.addToVis(this.vis,this.children);
		this.onSplit(this);
	};
	Circle.prototype.checkIntersection=function(startPoint,endPoint){
		var edx=this.x-endPoint[0],edy=this.y-endPoint[1],sdx=this.x-startPoint[0],sdy=this.y-startPoint[1],r2=this.size/2;r2=r2*r2;
		return edx*edx+edy*edy<=r2&&sdx*sdx+sdy*sdy>r2;
	};
	Circle.addToVis=function(vis,circles,init){
		var circle=vis.selectAll('.nope').data(circles).enter().append('circle');
		if(init){
			circle=circle.attr('cx',function(d){return d.x;}).attr('cy',function(d){return d.y;}).attr('r',4).attr('fill','#ffffff').transition().duration(1000);
		}
		else{
			circle=circle.attr('cx',function(d){return d.parent.x;}).attr('cy',function(d){return d.parent.y;}).attr('r',function(d){return d.parent.size/2;}).attr('fill',function(d){return String(d.parent.rgb);}).attr('fill-opacity',0.68).transition().duration(300);
		}
		circle.attr('cx',function(d){return d.x;}).attr('cy',function(d){return d.y;}).attr('r',function(d){return d.size/2;}).attr('fill',function(d){return String(d.rgb);}).attr('fill-opacity',1).each('end',function(d){d.node=this;});
	};
	// property settings
	var vis,dots = document.getElementById("dots"),maxSize = dots.offsetWidth - 40,minSize = maxSize===256?4:8,dim = maxSize/minSize
		//start properties
		,startButton = document.getElementById("start"),start=false,startCheck,Timer,currentTime = 0,timeElement = document.getElementsByTagName("time")[0]
		//end prperties
		,token=document.getElementsByName("_token")[0].value,endToken=false;

	koala.loadImage=function(imageData){
		var canvas=document.createElement('canvas').getContext('2d');
		canvas.drawImage(imageData,0,0,dim,dim);
		return canvas.getImageData(0,0,dim,dim).data;
	};
	koala.makeCircles=function(selector,colorData,onEvent){
		onEvent=onEvent||function(){};
		var splitableByLayer=[],splitableTotal=0,nextPercent=0;
		function onSplit(circle){
			var layer=circle.layer;
			splitableByLayer[layer]--;
			if(splitableByLayer[layer]===0 && (layer===0||layer===5)){
				onEvent('LayerClear',layer);
			}
			var percent=1-d3.sum(splitableByLayer)/splitableTotal;
			if(percent>=nextPercent){
				onEvent('PercentClear',Math.round(nextPercent*100));
				nextPercent+=0.05;
			}
		}
		if(!vis){
			vis=d3.select(selector).append("svg").attr("width",maxSize).attr("height",maxSize);
		}
		else{
			vis.selectAll('circle').remove();
		}
		var finestLayer=array2d(dim,dim);
		var size=minSize;
		var xi,yi,t=0,color;
		for(yi=0;yi<dim;yi++){
			for(xi=0;xi<dim;xi++){
				color=[colorData[t],colorData[t+1],colorData[t+2]];
				finestLayer(xi,yi,new Circle(vis,xi,yi,size,color));
				t+=4;
			}
		}
		var layer,prevLayer=finestLayer;
		var c1,c2,c3,c4,currentLayer=0;
		while(size<maxSize){
			dim/=2;
			size=size*2;
			layer=array2d(dim,dim);
			for(yi=0;yi<dim;yi++){
				for(xi=0;xi<dim;xi++){
					c1=prevLayer(2*xi,2*yi);
					c2=prevLayer(2*xi+1,2*yi);
					c3=prevLayer(2*xi,2*yi+1);
					c4=prevLayer(2*xi+1,2*yi+1);
					color=avgColor(c1.color,c2.color,c3.color,c4.color);
					c1.parent=c2.parent=c3.parent=c4.parent=layer(xi,yi,new Circle(vis,xi,yi,size,color,[c1,c2,c3,c4],currentLayer,onSplit));
				}
			}
			splitableByLayer.push(dim*dim);
			splitableTotal+=dim*dim;currentLayer++;
			prevLayer=layer;
		}
		Circle.addToVis(vis,[layer(0,0)],true);
		function splitableCircleAt(pos){
			var xi=Math.floor(pos[0]/minSize),yi=Math.floor(pos[1]/minSize),circle=finestLayer(xi,yi);
			if(!circle)return null;
			while(circle&&!circle.isSplitable())circle=circle.parent;
			return circle||null;
		}
		function intervalLength(startPoint,endPoint){
			var dx=endPoint[0]-startPoint[0],dy=endPoint[1]-startPoint[1];
			return Math.sqrt(dx*dx+dy*dy);
		}
		function breakInterval(startPoint,endPoint,maxLength){
			var breaks=[],length=intervalLength(startPoint,endPoint),numSplits=Math.max(Math.ceil(length/maxLength),1),dx=(endPoint[0]-startPoint[0])/numSplits,dy=(endPoint[1]-startPoint[1])/numSplits,startX=startPoint[0],startY=startPoint[1];
			for(var i=0;i<=numSplits;i++){
				breaks.push([startX+dx*i,startY+dy*i]);
			}
			return breaks;
		}
		function findAndSplit(startPoint,endPoint){
			var breaks=breakInterval(startPoint,endPoint,4);
			var circleToSplit=[];
			for(var i=0;i<breaks.length-1;i++){
				var sp=breaks[i],ep=breaks[i+1];
				var circle=splitableCircleAt(ep);
				if(circle&&circle.isSplitable()&&circle.checkIntersection(sp,ep)){
					circle.split();
				}
			}
		}
		var prevMousePosition=null;
		function onMouseMove(){
			var mousePosition=d3.mouse(vis.node());
			if(isNaN(mousePosition[0])){
				prevMousePosition=null;
				return;
			}
			if(prevMousePosition){
				findAndSplit(prevMousePosition,mousePosition);
			}
			prevMousePosition=mousePosition;
			d3.event.preventDefault();
		}
		var prevTouchPositions={};
		function onTouchMove(){
			var touchPositions=d3.touches(vis.node());
			for(var touchIndex=0;touchIndex<touchPositions.length;touchIndex++){
				var touchPosition=touchPositions[touchIndex];
				var prevTouchPosition=prevTouchPositions[touchPosition.identifier];
				if(prevTouchPosition){
					findAndSplit(prevTouchPosition,touchPosition);
				}
				prevTouchPositions[touchPosition.identifier]=touchPosition;
			}
			d3.event.preventDefault();
		}
		function onTouchEnd(){
			var touches=d3.event.changedTouches;
			for(var touchIndex=0;touchIndex<touches.length;touchIndex++){
				var touch=touches.item(touchIndex);
				prevTouchPositions[touch.identifier]=null;
			}
			d3.event.preventDefault();
		}
		d3.select("div#dots").on('mousemove.koala',onMouseMove).on('touchmove.koala',onTouchMove).on('touchend.koala',onTouchEnd).on('touchcancel.koala',onTouchEnd);

		// adding start move for better usability
		startCheck = setInterval(function(){ (start)?findAndSplit([0, 0], [125, 125]):null; },100);
	};

	// loading
	window.shownFile='none';
	if(!koala.supportsCanvas()){
		alert("Sorry, Je moet de site openen in een browser die HTML5 Canvas ondersteund. Zoals: Chrome, Safari, Firefox, Opera, en Internet Explorer vanaf versie 10");
		return;
	}
	if(!koala.supportsSVG()){
		alert("Sorry, Je moet de site openen in een browser die SVG ondersteund. Zoals: Chrome, Safari, Firefox, Opera, en Internet Explorer vanaf versie 10");
		return;
	}
	function basicLoad(location){
		var file=possible[Math.floor(Math.random()*possible.length)];
		return{file:file,shownFile:location.protocol+'//'+location.host+file};
	}
	var parse=basicLoad(location);
	if(!parse)return;
	var file=parse.file;window.shownFile=parse.shownFile;
	function onEvent(what,value){
		if(what === 'LayerClear' && value === 0){
			document.getElementById("msg").classList.add("show");
			//stop counting
			clearInterval(Timer);

			// time to form
			document.getElementsByName("time")[0].value = currentTime;

			//send
			sendIt("end",true,handleEnd);

		}
		if(what === 'LayerClear' && value === 5){
			// stop the startCheck
			clearInterval(startCheck);

			//start counting
			Timer = setInterval(optellen, 100);

			//send
			sendIt("start",true,handleStart);

		}
	}
	var img=new Image();
	img.onload=function(){
		var colorData;
		colorData=koala.loadImage(this);
		if(colorData){
			koala.makeCircles("#dots",colorData,onEvent);
		}
	};
	img.src=file;

	// start button
	startButton.addEventListener("click", begin);

	function begin(e){
		e.preventDefault();
		document.getElementById("game").removeAttribute("class");
		start = true;
	}
	function optellen(){
		++currentTime;
		timeElement.innerHTML = visualTime(currentTime);
	}
	function visualTime(timeInPartsOfSeconds){
		var nthOfASecond = 10
			, minutePart = addZeroAndRound(((timeInPartsOfSeconds/nthOfASecond)/60)%60,2)
			, secondsPart = addZeroAndRound((timeInPartsOfSeconds/nthOfASecond)%60,2)
			, secondsAfterKommaPart = addZeroAndRound(timeInPartsOfSeconds%nthOfASecond,1);
		return minutePart + ":" + secondsPart + "," + secondsAfterKommaPart;
	}
	function addZeroAndRound(number,length){
		number = Math.floor(number);
		return ((number+"").length < length)?"0" + number:number;
	}
	function sendIt(to,getting,back){
		var xhttp = new XMLHttpRequest(),data;
		data = "_token=" + token + "&ip=" + document.getElementsByName("ip")[0].value;
		if(endToken){
			data += "&et="+endToken+"&ti="+currentTime;
		}

		xhttp.open("POST",location.href.substr(0,location.href.length - 5) + "/" + to + "");
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		xhttp.setRequestHeader("X-XSRF-TOKEN", document.cookie.substr(11));

		if(getting){
			xhttp.onreadystatechange = function(){
				if(xhttp.readyState === 4 && xhttp.status === 200){
					(back)(xhttp.responseText);
				}
			};
		}
		xhttp.send(data);
	}
	function handleStart(response){
		endToken = response;
	}
	function handleEnd(response){
		handleStart(response);
		var et = document.createElement("input");
		et.type = "hidden";
		et.value = endToken;
		et.name = "et";
		document.getElementsByTagName("form")[0].appendChild(et);
	}
})(window);