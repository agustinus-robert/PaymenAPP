<div>
	<div class="slide-controls">
        <input type="radio" c;a wire:change="radios($event.target.value)" name="slide" id="login" value="login" {{$cek == 'login' || $cek == '' ? 'checked' : ''}}  />
        <input type="radio" wire:change="radios($event.target.value)" name="slide" id="signup" value="signup" {{$cek == 'signup' ? 'checked' : ''}} />
        <label for="login" class="slide login">Sign In</label>
        <label for="signup" class="slide signup">Sign up</label>
        <div class="slider-tab"></div>
    </div>
    
    <div class="form-inner">
		<form class="login" wire:submit="actionLogin" style={{$cek == 'login' || $cek == '' ? 'display:block;' : 'display:none;'}}>
	        <div class="field">
	            <label for=""><strong>Username</strong>
	              </label>
	            <input wire:model="username_login" type="text" placeholder="" required />
	        </div>
	        <br />
	        <div class="field">
	            <label><strong>Password</strong></label>
	            <input wire:model="password_login" type="password" placeholder="" required />
	        </div>
	        <br />
	        <div class="field btn">
	            <button type="submit">Login</button>
	        </div>
	    </form>

	    <form class="signup" wire:submit="saveSignup" style={{$cek == 'signup' ? 'display:block;' : 'display:none;'}}>
	        <div class="field">
	            <label for=""><strong>Full Name</strong>
	              </label>
	            <input wire:model="fullname_signup" type="text" placeholder="" required />
	        </div>
	        <br />
	        <div class="field">
	            <label for=""><strong>
	                  Email Address</strong>
	              </label>
	            <input type="email" wire:model="email_signup" placeholder="" required />
	        </div>
	        <br />
	        <div class="field">
	            <label for=""><strong>
	                  Phone Number</strong>
	              </label>
	            <input type="text" wire:model="phone_signup" placeholder="" required />
	        </div>
	        <br />
	         <div class="field">
	            <label for=""><strong>
	                  Username</strong>
	              </label>
	            <input type="text" wire:model="username_signup" placeholder="" required />
	        </div>
	        <br />
	        <div class="field">
	            <label for=""><strong>
	                  Password</strong>
	              </label>
	            <input type="password" wire:model="password_signup" placeholder="" required />
	        </div>
	        <br />
	        
	        <div class="field">
	        	<label for=""><strong>
	                  Alamat</strong>
	            </label>

	            <textarea wire:model="address_signup" placeholder=""></textarea>
	        </div>
	        <br />

	        <div class="field">
	        	<label for=""><strong>
	                  Nota Tambahan</strong>
	            </label>

	            <textarea wire:model="note_signup" placeholder=""></textarea>
	        </div>
	        <br />

	        <div class="field btn">
	            <button type="submit">Sign Up</button>
	        </div>
	    </form>
    </div>

    @push('scripts')
    <script>
    	$(document).ready(function(){
    		$('#roles').on('change', function(){
    			@this.set('role_signup', $(this).val())
    		})
    	})
    </script>
    @endpush
</div>