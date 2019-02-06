<?php
use antkaz\vue\VueAsset;
VueAsset::register($this); // register VueAsset

$this->registerCssFile('../../css/test1.css');
?>

<div id="components-demo">
    <button-counter></button-counter>
</div>

<script>
    // Определяем новый компонент, названный button-counter
    Vue.component('button-counter', {
        data: function () {
            return {
                count: 0
            }
        },
        template: '<button v-on:click="count++">Счётчик кликов — {{ count }}</button>'
    })

    new Vue({ el: '#components-demo' })

</script>