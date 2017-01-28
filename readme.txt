user wants a power account for 10 / mo

user buys something:
	user creates a new cart with status pending
		if this is only a one time payment, we try to deduct it from user's wallet otherwise we create a new subscription
		if this is a recurring payment, we create a new subscription

to create a new subscription:
	user goes to paypal
		user creates a $10 / sub
		user comes back to site via pdt
	user is not upgraded since ipn is not recd.
	user is told we are waiting for confirmation

when we get ipn 
	pass: we add money to wallet and then dispatch success for cart (same for recurring)
	fail: we do nothing
	refund: we deduct money from the wallet and then dispatch refund for cart 
	cancel: we then dispatch cancel for cart
	
when cart recieves payment confirmation
	we make a purchase from the wallet (same for recurring)
		if successful
			we update cart status as
				if one time ->  status = complete: 
				if recurring -> status = rebill, rebill_at => next bill date
			we give user access as per the product attached to this cart
	

when cart recieves refund confirmation
	we update cart status as 
		cancel
	we take away access to the product attached to this cart
	
when cart recieves refund confirmation
	we update cart status as 
		cancel
		
we run a cron job on all carts that have status pending, or rebill_date < now() and m_cart_retries.next_try < now() and m_cart_retries.tries < 3
	if status is pending
		we tell user that we have not got the money
	if rebill_date < now() - 1
		we tell user that subscription has failed
	we increase tries and set next_try to now + 1 in m_cart_retries

if a user cancels a cart
	we stop the recurring billing on paypal also
	we set cart status to cancel
			