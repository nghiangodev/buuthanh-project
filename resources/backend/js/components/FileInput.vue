<template>
    <div class="fileinput fileinput-new">
        <div class="input-group">
            <div class="form-control" data-trigger="fileinput">
                <i class="far fa-file fileinput-exists"></i>
                <span class="fileinput-filename"></span>
            </div>
            <div class="input-group-append">
                <div class="btn-group" role="group" aria-label="...">
                    <button class="btn btn-brand btn-file" type=button>
                        <span class="fileinput-new" v-html=chooseFileText></span>
                        <span class="fileinput-exists" v-html=changeFileText></span>
                        <input type="file" :name="name" :accept="accept">
                    </button>
                    <!--                    <button class="btn btn-sm btn-success fileinput-exists" type="button" id="btn_confirm_file" v-html=confirmFileText></button>-->
                    <button type="button" class="btn btn-danger fileinput-exists" data-dismiss="fileinput" id="btn_clear_file" v-html=deleteFileText></button>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .input-group i {
        color: inherit;
    }
</style>
<script>
	// noinspection JSUnusedGlobalSymbols
	export default {
		props: {
			name: {
				type: String,
				default: 'file',
			},
			accept: {
				type: String,
				default: '*/*',
			},
		},

		mounted() {
			$('.fileinput').fileinput()
		},

		data() {
			return {
				changeFileText: `<i class="far fa-redo"></i> ${__('Change file')}`,
				chooseFileText: `<i class="far fa-folder-open"></i> ${__('Choose file')}`,
				deleteFileText: `<i class="far fa-trash"></i> ${__('Delete')}`,
				confirmFileText: `<i class="far fa-check"></i> ${__('Confirm')}`,
			}
		},

		methods: {},
	}
</script>
