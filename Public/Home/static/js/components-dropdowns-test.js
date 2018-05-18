var ComponentsDropdowns = function () {

    var handleSelect2 = function () {



        $('#select2_sample2').select2({
            placeholder: "请选择",
            allowClear: true
        });

       
    }

    var handleSelect2Modal = function () {

        $('#select2_sample_modal_2').select2({
            placeholder: "Select a State",
            allowClear: true
        });


    }

   /* var handleBootstrapSelect = function() {
        $('.bs-select').selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });
    }

    var handleMultiSelect = function () {
        $('#my_multi_select1').multiSelect();
        $('#my_multi_select2').multiSelect({
            selectableOptgroup: true
        });
    }*/

    return {
        //main function to initiate the module
        init: function () {            
            handleSelect2();
            handleSelect2Modal();
            //handleMultiSelect();
            //handleBootstrapSelect();
        }
    };

}();