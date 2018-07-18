app for tracking http-requests.
requires docker & docker-compose

by default, will run on host `request-tracker.localhost`

getting started (hint: proceed with sudo if current user isn't in docker group):
  `make build && make run`
  
active endpoints: 
  Name                       Method   Scheme   Host   Path                               
 -------------------------- -------- -------- ------ ----------------------------------- 
  app_api_add                ANY      ANY      ANY    /api/create                        
  app_api_retrieve           ANY      ANY      ANY    /api/retrieve                      
 
