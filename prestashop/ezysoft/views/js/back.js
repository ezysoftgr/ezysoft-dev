/**
* 2007-2024 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2024 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/



function process(e, t, type){
    Swal.fire({
        title: window.ezySoft.trans.start,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: window.ezySoft.trans.yes,
        denyButtonText: window.ezySoft.trans.no,
        closeOnConfirm: false,
        allowOutsideClick: false
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

            $.ajax({
                url: window.ezySoft.api,
                async: true,
                dataType: 'JSON',
                method: 'GET',
                data:{
                    ajax : true,
                    action: type,
                },
                beforeSend : function (){
                    let timerInterval
                    Swal.fire({
                        title: window.ezySoft.trans.wait,
                        html: window.ezySoft.trans.coffee,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        },
                        allowOutsideClick: false
                    });
                },
                success : function(res) {


                    if (res.error){
                        $.growl.error({message: res.messages, size: "large"})
                        // $.each(res.messages, function (key, val) {
                        //     $.growl.error({message: 'test', size: "large"})
                        // });
                    }else{
                        $.growl.notice({ message: res.messages,  size: "large" });
                    }



                },
                complete: function (){

                    swal.close();
                 window.location.reload();
                },


            })

        }else if (result.isDenied) {
            swal.close();
        }
    });
}




function copyClipboard(inputElement) {

    inputElement.select();
    document.execCommand("copy");
    inputElement.blur()
    const button = inputElement.nextElementSibling;
    const tooltip = button ? button.firstElementChild : null;
    $.growl.notice({ message:  window.ezySoft.trans.copy,  size: "large" });

}