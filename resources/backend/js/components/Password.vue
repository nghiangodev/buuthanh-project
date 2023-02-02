<template>
	<div class="kt-input-icon kt-input-icon--right">
		<input :id="id" :type="inputType" class="form-control" :name="name" :placeholder="passwordText" :title="passwordText" :data-msg-pwCheck="message">
		<span class="kt-input-icon__icon kt-input-icon__icon--right toggle-password" style="cursor: pointer" v-on:click="togglePassword"><span><i :class="icon"></i></span></span>
	</div>
</template>
<script>
	export default {
		props: {
			message: String,
			placeholder: {
				type: String,
			},
			id: {
				type: String,
				default: 'txt_password',
			},
			name: {
				type: String,
				default: 'password',
			},
		},

		created() {
			if (! this.placeholder) {
				this.placeholder = window.__('Password');
			}
		},

		data() {
			return {
				passwordText: this.placeholder || window.__('Password'),
				inputType: 'password',
				icon: 'far fa-eye',
			}
		},

		methods: {
			togglePassword() {
				this.icon = this.icon === 'far fa-eye' ? 'far fa-eye-slash' : 'far fa-eye'
				this.inputType = this.inputType === 'password' ? 'text' : 'password'
			},
		},
	}
</script>
<style scoped></style>