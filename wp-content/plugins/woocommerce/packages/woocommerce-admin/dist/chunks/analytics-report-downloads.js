(window.__wcAdmin_webpackJsonp=window.__wcAdmin_webpackJsonp||[]).push([[10],{482:function(e,t,r){"use strict";r.r(t),r.d(t,"default",(function(){return A}));var o=r(0),c=r(1),a=r.n(c),n=r(533),d=r(2),l=r(7),m=r(3),i=r(9),s=r.n(i),u=r(21),b=r(12),_=r(120),p=r(15),w=r(11),O=r(19),f=r(502),j=r(497);class y extends o.Component{constructor(){super(),this.getHeadersContent=this.getHeadersContent.bind(this),this.getRowsContent=this.getRowsContent.bind(this),this.getSummary=this.getSummary.bind(this)}getHeadersContent(){return[{label:Object(d.__)("Date",'woocommerce'),key:"date",defaultSort:!0,required:!0,isLeftAligned:!0,isSortable:!0},{label:Object(d.__)("Product Title",'woocommerce'),key:"product",isSortable:!0,required:!0},{label:Object(d.__)("Tên tập tin",'woocommerce'),key:"file_name"},{label:Object(d.__)("Đơn hàng #",'woocommerce'),screenReaderLabel:Object(d.__)("Order Number",'woocommerce'),key:"order_number"},{label:Object(d.__)("Username",'woocommerce'),key:"user_id"},{label:Object(d.__)("IP",'woocommerce'),key:"ip_address"}]}getRowsContent(e){const{query:t}=this.props,r=Object(b.getPersistedQuery)(t),c=Object(p.f)("dateFormat",O.defaultTableDateFormat);return Object(m.map)(e,e=>{const{_embedded:t,date:a,file_name:n,file_path:l,ip_address:m,order_id:i,order_number:s,product_id:_,username:w}=e,{code:O,name:f}=t.product[0];let j,y;if("woocommerce_rest_product_invalid_id"===O)j=Object(d.__)("(Deleted)",'woocommerce'),y=Object(d.__)("(Deleted)",'woocommerce');else{const e=Object(b.getNewPath)(r,"/analytics/products",{filter:"single_product",products:_});j=Object(o.createElement)(u.Link,{href:e,type:"wc-admin"},f),y=f}return[{display:Object(o.createElement)(u.Date,{date:a,visibleFormat:c}),value:a},{display:j,value:y},{display:Object(o.createElement)(u.Link,{href:l,type:"external"},n),value:n},{display:Object(o.createElement)(u.Link,{href:Object(p.e)(`post.php?post=${i}&action=edit`),type:"wp-admin"},s),value:s},{display:w,value:w},{display:m,value:m}]})}getSummary(e){const{download_count:t=0}=e,{query:r,defaultDateRange:o}=this.props,c=Object(O.getCurrentDates)(r,o),a=s()(c.primary.after),n=s()(c.primary.before).diff(a,"days")+1,l=this.context.getCurrencyConfig();return[{label:Object(d._n)("ngày","days",n,'woocommerce'),value:Object(_.formatValue)(l,"number",n)},{label:Object(d._n)("tải xuống","downloads",t,'woocommerce'),value:Object(_.formatValue)(l,"number",t)}]}render(){const{query:e,filters:t,advancedFilters:r}=this.props;return Object(o.createElement)(f.a,{endpoint:"downloads",getHeadersContent:this.getHeadersContent,getRowsContent:this.getRowsContent,getSummary:this.getSummary,summaryFields:["download_count"],query:e,tableQuery:{_embed:!0},title:Object(d.__)("Downloads",'woocommerce'),columnPrefsKey:"downloads_report_columns",filters:t,advancedFilters:r})}}y.contextType=j.a;var h=Object(l.withSelect)(e=>{const{woocommerce_default_date_range:t}=e(w.SETTINGS_STORE_NAME).getSetting("wc_admin","wcAdminSettings");return{defaultDateRange:t}})(y),v=r(504),g=r(503),S=r(505),E=r(501);class A extends o.Component{render(){const{query:e,path:t}=this.props;return Object(o.createElement)(o.Fragment,null,Object(o.createElement)(E.a,{query:e,path:t,filters:n.c,advancedFilters:n.a,report:"downloads"}),Object(o.createElement)(S.a,{charts:n.b,endpoint:"downloads",query:e,selectedChart:Object(v.a)(e.chart,n.b),filters:n.c,advancedFilters:n.a}),Object(o.createElement)(g.a,{charts:n.b,endpoint:"downloads",path:t,query:e,selectedChart:Object(v.a)(e.chart,n.b),filters:n.c,advancedFilters:n.a}),Object(o.createElement)(h,{query:e,filters:n.c,advancedFilters:n.a}))}}A.propTypes={query:a.a.object.isRequired}},498:function(e,t,r){"use strict";r.d(t,"e",(function(){return s})),r.d(t,"a",(function(){return u})),r.d(t,"b",(function(){return b})),r.d(t,"c",(function(){return _})),r.d(t,"d",(function(){return p})),r.d(t,"f",(function(){return w})),r.d(t,"h",(function(){return O})),r.d(t,"g",(function(){return f}));var o=r(14),c=r(17),a=r.n(c),n=r(3),d=r(12),l=r(11),m=r(15),i=r(499);function s(e,t=n.identity){return function(r="",c){const n="function"==typeof e?e(c):e,l=Object(d.getIdsFromQuery)(r);if(l.length<1)return Promise.resolve([]);const m={include:l.join(","),per_page:l.length};return a()({path:Object(o.addQueryArgs)(n,m)}).then(e=>e.map(t))}}s(l.NAMESPACE+"/products/attributes",e=>({key:e.id,label:e.name}));const u=s(l.NAMESPACE+"/products/categories",e=>({key:e.id,label:e.name})),b=s(l.NAMESPACE+"/coupons",e=>({key:e.id,label:e.code})),_=s(l.NAMESPACE+"/customers",e=>({key:e.id,label:e.name})),p=s(l.NAMESPACE+"/products",e=>({key:e.id,label:e.name})),w=s(l.NAMESPACE+"/taxes",e=>({key:e.id,label:Object(i.a)(e)}));function O({attributes:e,name:t}){const r=Object(m.f)("variationTitleAttributesSeparator"," - ");if(t.indexOf(r)>-1)return t;const o=e.map(({option:e})=>e).join(", ");return o?t+r+o:t}const f=s(({products:e})=>e?l.NAMESPACE+`/products/${e}/variations`:l.NAMESPACE+"/variations",e=>({key:e.id,label:O(e)}))},499:function(e,t,r){"use strict";r.d(t,"a",(function(){return c}));var o=r(2);function c(e){return[e.country,e.state,e.name||Object(o.__)("TAX",'woocommerce'),e.priority].map(e=>e.toString().toUpperCase().trim()).filter(Boolean).join("-")}},533:function(e,t,r){"use strict";r.d(t,"b",(function(){return n})),r.d(t,"c",(function(){return d})),r.d(t,"a",(function(){return l}));var o=r(2),c=r(30),a=r(498);const n=Object(c.applyFilters)("woocommerce_admin_downloads_report_charts",[{key:"download_count",label:Object(o.__)("Downloads",'woocommerce'),type:"number"}]),d=Object(c.applyFilters)("woocommerce_admin_downloads_report_filters",[{label:Object(o.__)("Show",'woocommerce'),staticParams:["chartType","paged","per_page"],param:"filter",showFilters:()=>!0,filters:[{label:Object(o.__)("Tất cả tải xuống",'woocommerce'),value:"all"},{label:Object(o.__)("Bộ lọc nâng cao",'woocommerce'),value:"advanced"}]}]),l=Object(c.applyFilters)("woocommerce_admin_downloads_report_advanced_filters",{title:Object(o._x)("Tải xuống tương ứng với {{select /}} bộ lọc","A sentence describing filters for Downloads. See screen shot for context: https://cloudup.com/ccxhyH2mEDg",'woocommerce'),filters:{product:{labels:{add:Object(o.__)("Product",'woocommerce'),placeholder:Object(o.__)("Search",'woocommerce'),remove:Object(o.__)("Remove product filter",'woocommerce'),rule:Object(o.__)("Select a product filter match",'woocommerce'),title:Object(o.__)("{{title}}Sản phẩm{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(o.__)("Select product",'woocommerce')},rules:[{value:"includes",label:Object(o._x)("Bao gồm","products",'woocommerce')},{value:"excludes",label:Object(o._x)("Không bao gồm","products",'woocommerce')}],input:{component:"Search",type:"products",getLabels:a.d}},customer:{labels:{add:Object(o.__)("Username",'woocommerce'),placeholder:Object(o.__)("Search customer username",'woocommerce'),remove:Object(o.__)("Remove customer username filter",'woocommerce'),rule:Object(o.__)("Select a customer username filter match",'woocommerce'),title:Object(o.__)("{{title}}Tài khoản{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(o.__)("Chọn tài khoản khách hàng",'woocommerce')},rules:[{value:"includes",label:Object(o._x)("Bao gồm","customer usernames",'woocommerce')},{value:"excludes",label:Object(o._x)("Không bao gồm","customer usernames",'woocommerce')}],input:{component:"Search",type:"usernames",getLabels:a.c}},order:{labels:{add:Object(o.__)("Đơn hàng #",'woocommerce'),placeholder:Object(o.__)("Chọn số đơn hàng",'woocommerce'),remove:Object(o.__)("Xóa bộ lọc đơn hàng",'woocommerce'),rule:Object(o.__)("Chọn đơn hàng lọc tương ứng",'woocommerce'),title:Object(o.__)("{{title}}Đơn hàng #{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(o.__)("Chọn số đơn hàng",'woocommerce')},rules:[{value:"includes",label:Object(o._x)("Bao gồm","order numbers",'woocommerce')},{value:"excludes",label:Object(o._x)("Không bao gồm","order numbers",'woocommerce')}],input:{component:"Search",type:"orders",getLabels:async e=>{const t=e.split(",");return await t.map(e=>({id:e,label:"#"+e}))}}},ip_address:{labels:{add:Object(o.__)("Địa chỉ IP",'woocommerce'),placeholder:Object(o.__)("Tìm địa chỉ IP",'woocommerce'),remove:Object(o.__)("Xọa lọc địa chỉ IP",'woocommerce'),rule:Object(o.__)("Chọn một địa chỉ IP tương ứng",'woocommerce'),title:Object(o.__)("{{title}}Địa chỉ IP{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(o.__)("Chọn địa chỉ IP",'woocommerce')},rules:[{value:"includes",label:Object(o._x)("Bao gồm","IP addresses",'woocommerce')},{value:"excludes",label:Object(o._x)("Không bao gồm","IP addresses",'woocommerce')}],input:{component:"Search",type:"downloadIps",getLabels:async e=>{const t=e.split(",");return await t.map(e=>({id:e,label:e}))}}}}})}}]);