


  (function ($) {
    "use strict";
    var jqueryProvince = $('#pwd_brand_province');
    
    if (jqueryProvince.length > 0) {
      $('#pwd_brand_province').select2({ id: '', placeholder: "Chọn Tỉnh/Thành phố",}).on('select2:select', function (e) {
        var provinceId = e.params.data.id;
        var provinceName = e.params.data.text;
        $('#pwd_brand_province_name').val(provinceName)
        $.ajax({
            type : "post",
            dataType : "json",
            url : pwb_ajax_object_admin.ajax_url,
            data : {
                action: "getDistricts",
                provinceId: provinceId,
                s: ""
            },
            // context: this,
            beforeSend: function(){
            },
            success: function(response) {
                response.data.unshift({id: '', text: 'Chọn Quận/Huyện' });
                $('#pwd_brand_district').html('').select2({
                  data:response.data
                })
            },
            error: function( jqXHR, textStatus, errorThrown ){
                console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        })
      });

      $('#pwd_brand_district').select2({ id: '', placeholder: "Chọn Quận/Huyện"}).on('select2:select', function (e) {
        var districtId = e.params.data.id;
        var districtName = e.params.data.text;
        $('#pwd_brand_district_name').val(districtName)
        $.ajax({
            type : "post",
            dataType : "json",
            url : pwb_ajax_object_admin.ajax_url,
            data : {
                action: "getWards",
                districtId: districtId,
                s: ""
            },
            // context: this,
            beforeSend: function(){
            },
            success: function(response) {
              response.data.unshift({id: '', text: 'Chọn Quận/Huyện' });
              $('#pwd_brand_ward').html('').select2({
                data: response.data
              });
            },
            error: function( jqXHR, textStatus, errorThrown ){
                console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        })
      });
      $('#pwd_brand_ward').select2({ id: '', placeholder: "Chọn Phường/Xã"}).on('select2:select', function (e) {
        var wardName = e.params.data.text;
        $('#pwd_brand_ward_name').val(wardName)
      })

    }
    
    /* ····························· /Brands exporter ····························· */
  
  })(jQuery)
  