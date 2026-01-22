<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate(): bool
	{
		$username = $this->username;
		$user = User::model()->find('username=:u', array(':u'=>$username));
		if($user === null){
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			return !$this->errorCode;
		}

		// verify password using password_verify (stored using password_hash)
		if(!function_exists('password_verify')){
			// fallback plain compare if password_verify not available
			$valid = ($user->password === $this->password);
		} else {
			$valid = password_verify($this->password, $user->password);
		}

		if(!$valid){
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			$this->errorCode = self::ERROR_NONE;
			// store identity into web user state
			if(method_exists(Yii::app()->user, 'setState')){
				Yii::app()->user->setState('username', $user->username);
				Yii::app()->user->setState('userId', $user->id);
			}
		}
		return !$this->errorCode;
	}
}