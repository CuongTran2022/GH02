(window.__wcAdmin_webpackJsonp=window.__wcAdmin_webpackJsonp||[]).push([[11],{479:function(e,t,o){"use strict";o.r(t),o.d(t,"default",(function(){return h}));var r=o(0),c=o(1),a=o.n(c),n=o(530),m=o(504),l=o(2),i=o(3),s=o(21),d=o(120),u=o(15),b=o(12),_=o(19),p=o(502),O=o(497);o(576);class j extends r.Component{constructor(){super(),this.getHeadersContent=this.getHeadersContent.bind(this),this.getRowsContent=this.getRowsContent.bind(this),this.getSummary=this.getSummary.bind(this)}getHeadersContent(){return[{label:Object(l.__)("Date",'woocommerce'),key:"date",required:!0,defaultSort:!0,isLeftAligned:!0,isSortable:!0},{label:Object(l.__)("Đơn hàng #",'woocommerce'),screenReaderLabel:Object(l.__)("Order Number",'woocommerce'),key:"order_number",required:!0},{label:Object(l.__)("Status",'woocommerce'),key:"status",required:!1,isSortable:!1},{label:Object(l.__)("Customer",'woocommerce'),key:"customer_id",required:!1,isSortable:!1},{label:Object(l.__)("Loại khách hàng",'woocommerce'),key:"customer_type",required:!1,isSortable:!1},{label:Object(l.__)("Sản phẩm(nhiều)",'woocommerce'),screenReaderLabel:Object(l.__)("Products",'woocommerce'),key:"products",required:!1,isSortable:!1},{label:Object(l.__)("Các mặt hàng đã bán",'woocommerce'),key:"num_items_sold",required:!1,isSortable:!0,isNumeric:!0},{label:Object(l.__)("Coupon(s)",'woocommerce'),screenReaderLabel:Object(l.__)("Coupons",'woocommerce'),key:"coupons",required:!1,isSortable:!1},{label:Object(l.__)("Doanh thu thuần",'woocommerce'),screenReaderLabel:Object(l.__)("Doanh thu thuần",'woocommerce'),key:"net_total",required:!0,isSortable:!0,isNumeric:!0}]}getCustomerName(e){const{first_name:t,last_name:o}=e||{};return t||o?[t,o].join(" "):""}getRowsContent(e){const{query:t}=this.props,o=Object(b.getPersistedQuery)(t),c=Object(u.f)("dateFormat",_.defaultTableDateFormat),{render:a,getCurrencyConfig:n}=this.context;return Object(i.map)(e,e=>{const{currency:t,date_created:m,net_total:i,num_items_sold:_,order_id:p,order_number:O,parent_id:j,status:w,customer_type:f}=e,y=e.extended_info||{},{coupons:v,customer:h,products:S}=y,g=S.sort((e,t)=>t.quantity-e.quantity).map(e=>({label:e.name,quantity:e.quantity,href:Object(b.getNewPath)(o,"/analytics/products",{filter:"single_product",products:e.id})})),C=v.map(e=>({label:e.code,href:Object(b.getNewPath)(o,"/analytics/coupons",{filter:"single_coupon",coupons:e.id})}));return[{display:Object(r.createElement)(s.Date,{date:m,visibleFormat:c}),value:m},{display:Object(r.createElement)(s.Link,{href:"post.php?post="+(j||p)+"&action=edit"+(j?"#order_refunds":""),type:"wp-admin"},O),value:O},{display:Object(r.createElement)(s.OrderStatus,{className:"woocommerce-orders-table__status",order:{status:w},orderStatusMap:Object(u.f)("orderStatuses",{})}),value:w},{display:this.getCustomerName(h),value:this.getCustomerName(h)},{display:(x=f,x.charAt(0).toUpperCase()+x.slice(1)),value:f},{display:this.renderList(g.length?[g[0]]:[],g.map(e=>({label:Object(l.sprintf)(Object(l.__)("%s× %s",'woocommerce'),e.quantity,e.label),href:e.href}))),value:g.map(({quantity:e,label:t})=>Object(l.sprintf)(Object(l.__)("%s× %s",'woocommerce'),e,t)).join(", ")},{display:Object(d.formatValue)(n(),"number",_),value:_},{display:this.renderList(C.length?[C[0]]:[],C),value:C.map(e=>e.label).join(", ")},{display:a(i,t),value:i}];var x})}getSummary(e){const{orders_count:t=0,total_customers:o=0,products:r=0,num_items_sold:c=0,coupons_count:a=0,net_revenue:n=0}=e,{formatAmount:m,getCurrencyConfig:i}=this.context,s=i();return[{label:Object(l._n)(" đơn hàng","orders",t,'woocommerce'),value:Object(d.formatValue)(s,"number",t)},{label:Object(l._n)(" khách hàng"," customers",o,'woocommerce'),value:Object(d.formatValue)(s,"number",o)},{label:Object(l._n)(" sản phẩm","products",r,'woocommerce'),value:Object(d.formatValue)(s,"number",r)},{label:Object(l._n)(" sản phẩm đã bán","items sold",c,'woocommerce'),value:Object(d.formatValue)(s,"number",c)},{label:Object(l._n)(" ưu đãi","coupons",a,'woocommerce'),value:Object(d.formatValue)(s,"number",a)},{label:Object(l.__)(" doanh thu thuần",'woocommerce'),value:m(n)}]}renderLinks(e=[]){return e.map((e,t)=>Object(r.createElement)(s.Link,{href:e.href,key:t,type:"wc-admin"},e.label))}renderList(e,t){return Object(r.createElement)(r.Fragment,null,this.renderLinks(e),t.length>1&&Object(r.createElement)(s.ViewMoreList,{items:this.renderLinks(t)}))}render(){const{query:e,filters:t,advancedFilters:o}=this.props;return Object(r.createElement)(p.a,{endpoint:"orders",getHeadersContent:this.getHeadersContent,getRowsContent:this.getRowsContent,getSummary:this.getSummary,summaryFields:["orders_count","total_customers","products","num_items_sold","coupons_count","net_revenue"],query:e,tableQuery:{extended_info:!0},title:Object(l.__)("Orders",'woocommerce'),columnPrefsKey:"orders_report_columns",filters:t,advancedFilters:o})}}j.contextType=O.a;var w=j,f=o(503),y=o(505),v=o(501);class h extends r.Component{render(){const{path:e,query:t}=this.props;return Object(r.createElement)(r.Fragment,null,Object(r.createElement)(v.a,{query:t,path:e,filters:n.c,advancedFilters:n.a,report:"orders"}),Object(r.createElement)(y.a,{charts:n.b,endpoint:"orders",query:t,selectedChart:Object(m.a)(t.chart,n.b),filters:n.c,advancedFilters:n.a}),Object(r.createElement)(f.a,{charts:n.b,endpoint:"orders",path:e,query:t,selectedChart:Object(m.a)(t.chart,n.b),filters:n.c,advancedFilters:n.a}),Object(r.createElement)(w,{query:t,filters:n.c,advancedFilters:n.a}))}}h.propTypes={path:a.a.string.isRequired,query:a.a.object.isRequired}},498:function(e,t,o){"use strict";o.d(t,"e",(function(){return d})),o.d(t,"a",(function(){return u})),o.d(t,"b",(function(){return b})),o.d(t,"c",(function(){return _})),o.d(t,"d",(function(){return p})),o.d(t,"f",(function(){return O})),o.d(t,"h",(function(){return j})),o.d(t,"g",(function(){return w}));var r=o(14),c=o(17),a=o.n(c),n=o(3),m=o(12),l=o(11),i=o(15),s=o(499);function d(e,t=n.identity){return function(o="",c){const n="function"==typeof e?e(c):e,l=Object(m.getIdsFromQuery)(o);if(l.length<1)return Promise.resolve([]);const i={include:l.join(","),per_page:l.length};return a()({path:Object(r.addQueryArgs)(n,i)}).then(e=>e.map(t))}}d(l.NAMESPACE+"/products/attributes",e=>({key:e.id,label:e.name}));const u=d(l.NAMESPACE+"/products/categories",e=>({key:e.id,label:e.name})),b=d(l.NAMESPACE+"/coupons",e=>({key:e.id,label:e.code})),_=d(l.NAMESPACE+"/customers",e=>({key:e.id,label:e.name})),p=d(l.NAMESPACE+"/products",e=>({key:e.id,label:e.name})),O=d(l.NAMESPACE+"/taxes",e=>({key:e.id,label:Object(s.a)(e)}));function j({attributes:e,name:t}){const o=Object(i.f)("variationTitleAttributesSeparator"," - ");if(t.indexOf(o)>-1)return t;const r=e.map(({option:e})=>e).join(", ");return r?t+o+r:t}const w=d(({products:e})=>e?l.NAMESPACE+`/products/${e}/variations`:l.NAMESPACE+"/variations",e=>({key:e.id,label:j(e)}))},499:function(e,t,o){"use strict";o.d(t,"a",(function(){return c}));var r=o(2);function c(e){return[e.country,e.state,e.name||Object(r.__)("TAX",'woocommerce'),e.priority].map(e=>e.toString().toUpperCase().trim()).filter(Boolean).join("-")}},530:function(e,t,o){"use strict";o.d(t,"b",(function(){return m})),o.d(t,"c",(function(){return l})),o.d(t,"a",(function(){return i}));var r=o(2),c=o(30),a=o(15),n=o(498);const m=Object(c.applyFilters)("woocommerce_admin_orders_report_charts",[{key:"orders_count",label:Object(r.__)("Orders",'woocommerce'),type:"number"},{key:"net_revenue",label:Object(r.__)("Doanh thu thuần",'woocommerce'),order:"desc",orderby:"net_total",type:"currency"},{key:"avg_order_value",label:Object(r.__)("Giá trị đặt hàng trung bình",'woocommerce'),type:"currency"},{key:"avg_items_per_order",label:Object(r.__)("Các mặt hàng trung bình trên mỗi đơn đặt hàng",'woocommerce'),order:"desc",orderby:"num_items_sold",type:"average"}]),l=Object(c.applyFilters)("woocommerce_admin_orders_report_filters",[{label:Object(r.__)("Show",'woocommerce'),staticParams:["chartType","paged","per_page"],param:"filter",showFilters:()=>!0,filters:[{label:Object(r.__)("Tất cả đơn đặt hàng",'woocommerce'),value:"all"},{label:Object(r.__)("Lọc nâng cao",'woocommerce'),value:"advanced"}]}]),i=Object(c.applyFilters)("woocommerce_admin_orders_report_advanced_filters",{title:Object(r._x)("Đối sánh đơn hàng {{select /}} Bộ lọc","A sentence describing filters for Orders. See screen shot for context: https://cloudup.com/cSsUY9VeCVJ",'woocommerce'),filters:{status:{labels:{add:Object(r.__)("Trạng thái đơn hàng",'woocommerce'),remove:Object(r.__)("Xóa bộ lọc trạng thái đơn hàng",'woocommerce'),rule:Object(r.__)("Chọn đối sánh bộ lọc trạng thái đơn hàng",'woocommerce'),title:Object(r.__)("{{title}}Trạng thái đơn hàng{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(r.__)("Chọn trạng thái đơn hàng",'woocommerce')},rules:[{value:"is",label:Object(r._x)("Là","order status",'woocommerce')},{value:"is_not",label:Object(r._x)("Không là","order status",'woocommerce')}],input:{component:"SelectControl",options:Object.keys(a.c).map(e=>({value:e,label:a.c[e]}))}},product:{labels:{add:Object(r.__)("Sản phẩm",'woocommerce'),placeholder:Object(r.__)("Tìm sản phẩm",'woocommerce'),remove:Object(r.__)("Xóa lọc sản phẩm",'woocommerce'),rule:Object(r.__)("Chọn đối sánh bộ lọc sản phẩm",'woocommerce'),title:Object(r.__)("{{title}}Sản phẩm{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(r.__)("Chọn sản phẩm",'woocommerce')},rules:[{value:"includes",label:Object(r._x)("Bao gồm","products",'woocommerce')},{value:"excludes",label:Object(r._x)("Không bao gồm","products",'woocommerce')}],input:{component:"Search",type:"products",getLabels:n.d}},variation:{labels:{add:Object(r.__)("Variations",'woocommerce'),placeholder:Object(r.__)("Search variations",'woocommerce'),remove:Object(r.__)("Remove variations filter",'woocommerce'),rule:Object(r.__)("Select a variation filter match",'woocommerce'),title:Object(r.__)("{{title}}Variation{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(r.__)("Select variation",'woocommerce')},rules:[{value:"includes",label:Object(r._x)("Includes","variations",'woocommerce')},{value:"excludes",label:Object(r._x)("Excludes","variations",'woocommerce')}],input:{component:"Search",type:"variations",getLabels:n.g}},coupon:{labels:{add:Object(r.__)("Mã ưu đãi",'woocommerce'),placeholder:Object(r.__)("Search coupons",'woocommerce'),remove:Object(r.__)("Remove coupon filter",'woocommerce'),rule:Object(r.__)("Select a coupon filter match",'woocommerce'),title:Object(r.__)("{{title}}Mã ưu đãi{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(r.__)("Select coupon codes",'woocommerce')},rules:[{value:"includes",label:Object(r._x)("Bao gồm","coupon code",'woocommerce')},{value:"excludes",label:Object(r._x)("Không bao gồm","coupon code",'woocommerce')}],input:{component:"Search",type:"coupons",getLabels:n.b}},customer_type:{labels:{add:Object(r.__)("Customer Type",'woocommerce'),remove:Object(r.__)("Remove customer filter",'woocommerce'),rule:Object(r.__)("Select a customer filter match",'woocommerce'),title:Object(r.__)("{{title}}Khách hàng là{{/title}} {{filter /}}",'woocommerce'),filter:Object(r.__)("Select a customer type",'woocommerce')},input:{component:"SelectControl",options:[{value:"new",label:Object(r.__)("Mới",'woocommerce')},{value:"returning",label:Object(r.__)("Quay lại",'woocommerce')}],defaultOption:"new"}},refunds:{labels:{add:Object(r.__)("Tiền hoàn lại",'woocommerce'),remove:Object(r.__)("Xóa bộ lọc hoàn tiền",'woocommerce'),rule:Object(r.__)("Chọn đối sánh bộ lọc hoàn tiền",'woocommerce'),title:Object(r.__)("{{title}}Tiền hoàn lại{{/title}} {{filter /}}",'woocommerce'),filter:Object(r.__)("Chọn loại hoàn tiền",'woocommerce')},input:{component:"SelectControl",options:[{value:"all",label:Object(r.__)("All",'woocommerce')},{value:"partial",label:Object(r.__)("Đã hoàn lại một phần",'woocommerce')},{value:"full",label:Object(r.__)("Đã hoàn lại đầy đủ",'woocommerce')},{value:"none",label:Object(r.__)("None",'woocommerce')}],defaultOption:"all"}},tax_rate:{labels:{add:Object(r.__)("Thuế xuất",'woocommerce'),placeholder:Object(r.__)("Tìm thuế xuất",'woocommerce'),remove:Object(r.__)("Xóa lọc thuế xuất",'woocommerce'),rule:Object(r.__)("Chọn đối sánh lọc thuế xuất",'woocommerce'),title:Object(r.__)("{{title}}Thuế xuất{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(r.__)("Chọn thuế xuất",'woocommerce')},rules:[{value:"includes",label:Object(r._x)("Bao gồm","tax rate",'woocommerce')},{value:"excludes",label:Object(r._x)("Không bao gồm","tax rate",'woocommerce')}],input:{component:"Search",type:"taxes",getLabels:n.f}},attribute:{allowMultiple:!0,labels:{add:Object(r.__)("Attribute",'woocommerce'),placeholder:Object(r.__)("Search attributes",'woocommerce'),remove:Object(r.__)("Remove attribute filter",'woocommerce'),rule:Object(r.__)("Select a product attribute filter match",'woocommerce'),title:Object(r.__)("{{title}}Thuộc tính{{/title}} {{rule /}} {{filter /}}",'woocommerce'),filter:Object(r.__)("Select attributes",'woocommerce')},rules:[{value:"is",label:Object(r._x)("Is","product attribute",'woocommerce')},{value:"is_not",label:Object(r._x)("Is Not","product attribute",'woocommerce')}],input:{component:"ProductAttribute"}}}})},576:function(e,t,o){}}]);