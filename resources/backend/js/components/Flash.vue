<template>
    <transition name="fade">
        <div class="alert alert-dismissible fade show p-3" :class="'alert-solid-' + level" role="alert" v-show="show">
            <div class="alert-close">
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true"><i class="far fa-times"></i></span>
                </button>
            </div>
            <strong v-html="body"></strong>
        </div>
    </transition>
</template><!--suppress CssUnusedSymbol -->
<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
<script>
	// noinspection JSUnusedGlobalSymbols
	export default {
		props: ['message', 'type'],

		data() {
			return {
				body: '',
				level: '',
				show: false,
			}
		},

		created() {
			if (this.message) {
				this.flash({message: this.message, level: this.type})
			}

			window.events.$on('flash', options => {
					let {message, level, hide} = options

					this.flash({message, level, hide})
				},
			)

			window.events.$on('hide', this.hide)
		},

		methods: {
			flash({message, level = 'success', hide = true}) {
				this.level = level
				this.body = message
				this.show = true
				if (hide) {
					setTimeout(() => this.show = false, 5000)
				}
			},
			hide() {
				this.show = false
			},
		},
	}
</script>
