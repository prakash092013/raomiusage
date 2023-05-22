(()=>{"use strict";var e={n:t=>{var l=t&&t.__esModule?()=>t.default:()=>t;return e.d(l,{a:l}),l},d:(t,l)=>{for(var n in l)e.o(l,n)&&!e.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:l[n]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.wp.element,l=window.wp.apiFetch;var n=e.n(l);const a=window.wp.components,r=window.wp.blockEditor,{__}=wp.i18n,{registerBlockType:o}=wp.blocks;o("raomi/demotable",{title:"Miusage API",icon:"universal-access-alt",category:"design",attributes:{hideId:{type:"boolean"},hideFirstName:{type:"boolean"},hideLastName:{type:"boolean"},hideEmail:{type:"boolean"},hideDate:{type:"boolean"}},edit(e){let{attributes:l,setAttributes:o}=e;const i=(0,r.useBlockProps)(),{hideId:c,hideFirstName:m,hideLastName:d,hideEmail:u,hideDate:s}=l,[E,g]=(0,t.useState)(),[h,b]=(0,t.useState)(!0);return(0,t.useEffect)((()=>{!async function(){n()({path:"/raomi/v1/usage"}).then((e=>{let t=e.data;b(!1),g(t)})).catch((e=>console.error(e)))}()}),[]),(0,t.createElement)("div",i,h?(0,t.createElement)("div",null,__("Loading Data","raomi")):(0,t.createElement)("div",{className:"raomi-table"},(0,t.createElement)("table",{cellPadding:5,cellSpacing:10},(0,t.createElement)("tr",null,c?null:(0,t.createElement)("td",null,(0,t.createElement)("strong",null,__("ID","raomi"))),m?null:(0,t.createElement)("td",null,(0,t.createElement)("strong",null,__("First Name","raomi"))),d?null:(0,t.createElement)("td",null,(0,t.createElement)("strong",null,__("Last Name","raomi"))),u?null:(0,t.createElement)("td",null,(0,t.createElement)("strong",null,__("Email","raomi"))),s?null:(0,t.createElement)("td",null,(0,t.createElement)("strong",null,__("Date","raomi")))),E&&E.map(((e,l)=>(0,t.createElement)("tr",{key:l},c?null:(0,t.createElement)("td",null,e.id),m?null:(0,t.createElement)("td",null,e.fname),d?null:(0,t.createElement)("td",null,e.lname),u?null:(0,t.createElement)("td",null,e.email),s?null:(0,t.createElement)("td",null,e.date)))))),(0,t.createElement)(r.InspectorControls,null,(0,t.createElement)(a.PanelBody,{title:__("Table column settings")},(0,t.createElement)(a.ToggleControl,{label:__("Hide ID","raomi"),checked:c,onChange:function(e){o({hideId:e})}}),(0,t.createElement)(a.ToggleControl,{label:__("Hide First Name","raomi"),checked:m,onChange:function(e){o({hideFirstName:e})}}),(0,t.createElement)(a.ToggleControl,{label:__("Hide Last Name","raomi"),checked:d,onChange:function(e){o({hideLastName:e})}}),(0,t.createElement)(a.ToggleControl,{label:__("Hide Email","raomi"),checked:u,onChange:function(e){o({hideEmail:e})}}),(0,t.createElement)(a.ToggleControl,{label:__("Hide Date","raomi"),checked:s,onChange:function(e){o({hideDate:e})}}))))},save(e){let{attributes:t}=e;return null}})})();