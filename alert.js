		function Alert(text,func,select=null,func_callback=null) {
            this._create(text,func,select,func_callback);
        }
        Alert.prototype = {
            constructor: Alert,
            html: [
                '<div class="alert">',
                    '<div class="alert-shadow"></div>',
                    '<div class="alert-dialog">',
						'<div class="alert-caption"><img id="buttonClose" src="images/delete_inactive.gif" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)"></div>',
                        '<div class="alert-text">',
                            '{TEXT}',
                        '</div>',
                        '<div class="alert-controls">',
                            '<button id="buttonOK">OK</button>',
                        '</div>',
                    '</div>',
                '</div>'
            ].join(""),
			isMoving : false,
			mouseX : 0,
			mouseY : 0,
            _rootElement: null,
            _create: function (text,func,select,func_callback) {
                var node = $("<div>");
                node.html(this.html.replace("{TEXT}", text));
                this._rootElement = node.children(":first");
				this._addEvents(func,select,func_callback);
            },
            _addEvents: function (f,select,func_callback) {
                var thisAlert = this;
                this._rootElement.find("button").click (function () {
					var tmp=new Array();
					tmp=thisAlert._rootElement.find('input[class!="selectBoxInput"],textarea');
					var attributes={};
					for(var t=0;t<tmp.length;t++)
					attributes[tmp[t].getAttribute('id')]=tmp[t];
					tmp=thisAlert._rootElement.find('input.selectBoxInput');
					if(tmp.length>0)
						for(t=0;t<tmp.length;t++)
						{
							var check=check_selectboxes(tmp[t]);
							if(check==-16)
							{
								create_clinic_alert(tmp[t],function(){thisAlert._rootElement.find("button").click();});
								return 0;
							}
							attributes[tmp[t].getAttribute('id')]=tmp[t];
						}
					if(select&&select!=null)
					if(f(attributes,select)>=0)
					{
						thisAlert.close();
						if(func_callback&&func_callback!=null)
						func_callback();
					}
					else
					alert('Ошибка!');
					else
					if(f(attributes)>=0)
					{
						thisAlert.close();
						if(func_callback&&func_callback!=null)
						func_callback();
					}
					else
					alert('Ошибка!');
                });
				this._rootElement.find("img").click (function () {
                    thisAlert.close();
				});
				this._rootElement.find(".alert-caption").mousedown(function (event) {
                    thisAlert.isMoving=true;
					thisAlert.mouseX=event.pageX;
					thisAlert.mouseY=event.pageY;
					event.stopPropagation();
				});
				this._rootElement.find(".alert-caption").mouseup(function (event) {
                    thisAlert.isMoving=false;
					event.stopPropagation();
				});
				$("body").mousemove(function (event) {
                    if(thisAlert.isMoving)
					{
						thisAlert._rootElement.find(".alert-dialog").css(
						{
							left:'+='+(event.pageX-thisAlert.mouseX),
							top:'+='+(event.pageY-thisAlert.mouseY)
						});
						thisAlert.mouseX=event.pageX;
						thisAlert.mouseY=event.pageY;
						event.stopPropagation();
					}
				});
				$("body").mouseleave(function (event) {
				thisAlert.isMoving=false;
				});
            },
            show: function () {
                $(document.body).append(this._rootElement);
				var h=this._rootElement.find('input[source][class!="selectBoxInput"]');
				h=$.makeArray(h);
				for(var t=0;t<h.length;t++)
				createEditableSelect(h[t]);
            },
            close: function () {
                $(this._rootElement).remove();
				$("body").unbind('mouseleave');
				$("body").unbind('mousemove');
            }
        };
