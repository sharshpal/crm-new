import AppForm from '../app-components/Form/AppForm';

Vue.component('sys-setting-form', {
    mixins: [AppForm],
    props: {
        colorNamesInput: String,
    },
    computed: {
        colorNamesList: {
            get: function () {
                return JSON.parse(this.colorNamesInput);
            }
        },
        primaryColorList:{
            get: function(){
                var cls = [];
                let arr = this.form.value.colors;
                console.log(arr.length);
                if(arr.length>6){
                    arr = arr.slice((arr.length-(arr.length-6))*-1);
                }

                for (let t of this.form.value.colors){
                    if(t.type=="color"){
                        cls.push(t.value);
                    }
                }

                console.log("PrimaryColorList: ",cls);
                return cls;
            }
        }
    },
    data: function() {
        return {
            form: {
                crm_user:  '' ,
                key:  '' ,
                value:  '' ,
            }
        }
    },
    methods:{
        isGlobalPanel(){
            return this.checkPanel("global");
        },
        isTemplatePanel(){
            return this.checkPanel("template");
        },
        checkPanel(panelName){
            let key = this.form.key;
            return key && key.id && key.id.length && key.id.toLowerCase()==panelName.toLowerCase();
        },
        onSetKey(){


        },
        colorChanged(newColor,colorObj){
          jQuery("body").get(0).style.setProperty("--"+colorObj.id, newColor, 'important');
          if(colorObj.type=="color"){
              this.setValueOfColor(colorObj.id+"-dark",this.adjustRgb(newColor,-50));
              this.setValueOfColor(colorObj.id+"-light",this.adjustRgb(newColor,50));
          }
        },
        getColorLabel(id){

            for(let t of this.colorNamesList){
                if(t.id == id){return t.name;}
            }

            return id;
        },
        setValueOfColor(id,newColor){
            let found = false;
            for(let t of this.form.value["colors"]){
                if(t.id == id){
                    t.value = newColor;
                    found = true;
                }
            }

            if(!found){
                this.form.value["colors"].push({
                    "id": id,
                    "value": newColor
                });
            }

            jQuery("body").get(0).style.setProperty("--"+id, newColor, 'important');
        },
        adjust(color, amount) {
            return '#' + color.replace(/^#/, '').replace(/../g, color => ('0'+Math.min(255, Math.max(0, parseInt(color, 16) + amount)).toString(16)).substr(-2));
        },
        adjustRgb(color,amount){
            return this.adjust(this.rgbStringToHex(color),amount);
        },
        rgbStringToHex(str){
            var a = str.split("(")[1].split(")")[0];
            a = a.split(",");
            var b = a.map(function(x){             //For each array element
                x = parseInt(x).toString(16);      //Convert to a base16 string
                return (x.length==1) ? "0"+x : x;  //Add zero if we get only one character
            });
            b = "#"+b.join("");
            return b;
        }

    },

});
