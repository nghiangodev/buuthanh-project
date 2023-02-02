<template>
    <a :href="route">
        <div class="kt-portlet kt-iconbox kt-iconbox--wave" :class="'kt-bg-light-' + color">
            <div class="kt-portlet__body my-p-20-0">
                <div class="kt-iconbox__body">
                    <div class="kt-iconbox__icon my-p-r-5">
                        <i class="fad fa-4x fa-fw" :class="'kt-font-' + color + ' ' + icon"></i>
                    </div>
                    <div class="kt-iconbox__desc">
                        <h3 class="kt-iconbox__title font-weight-bold my-auto" v-html="title"></h3>
                        <div class="kt-iconbox__content" v-if="content"><p v-html="content"></p></div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</template>
<script>
    export default {
        props: {
            title: String,
            content: String,
            icon: String,
            color: String,
            route: String,
        },
    }
</script>
<style scoped>
    .my-p-20-0 {
        padding: 15px 0;
    }

    .my-p-r-5 {
        padding-right: 5px !important;
    }
</style>
