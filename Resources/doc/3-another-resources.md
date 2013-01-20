Another resources
=================


Avoiding redirect to Facebook login page
----------------------------------------

When you're using only facebook as your firewall and a user go to a protected page on your application 
without being logged, they will be redirect to the Facebook login page.
If you want to avoid this behavior and redirect the user another page, you can set this option on the ```security.yml```, as the example above:

```yaml
firewalls:
	public:
		...
		fos_facebook:
			...
			redirect_to_facebook_login: false
```

When you set this option, any request not authenticated will be redirect to the default login page.