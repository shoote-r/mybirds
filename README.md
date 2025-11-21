# Information
Nom : SERIEYS
Prénom : Loris

# Presentation
This web app use is for each member to list the birds in their garden or their surroundings. Each member has a garden (inventory), birds (object) and can create aviaries (galerie).

Birds are lowkey cool so I thought they deserved more recognition yk


# Entities
## Entity model 
- [inventaire] = garden
- [objet] = birds
- [galerie] = aviary

- [membre] = member

## Entities association 
*go see markdown code directly* 

[inventaire]garden<----(1)-----(0..n)---->birds[objet]
		\                                            /
		 \                                          /
		  (1)                                     (0..n)
		   \                                      /
		    \                                    /
		     \                                  /
		      \                                /
		       \                              /
		       (0..n)                       (0..n)
		         \                          /
		          \                        /        
		              [galerie]aviary
		              

## Entities' properties 
#### User 
*Markdown tables cannot be rendered in Eclipse without a plugin which is why I'm not using them* 

**[inventaire]garden** 		              
- Properties : *description*, *size*, *name*
- Type : *String*, *int*, *String*
- Constraint : *nullable=true*, *PositiveOrZero*, *notnull*


**[objet]birds** 
- Properties : *description*, *name*
- Type : *String*, *String*
- Constraint : none, *notnull*

**[membre]member**
- go see realization guide
 
# -----NAVIGATION GUIDE-----

This guide explains how to navigate the application depending on the user role:  
Administrator (ROLE_ADMIN) or User (ROLE_USER).

---

## 1. Administrator Navigation (ROLE_ADMIN)

### Access
- Go to `/`
- Log in with an admin account (e.g. `admin@localhost`, pwd : `admin123`)

Admins can access every feature and all data.

### Gardens
- Click **“Gardens”** in the navigation bar  
- Admins see **all gardens**

Actions available:
- Show  
- Edit  
- View all birds inside the garden (“All birds”)

### Birds
Inside any garden:
- Click **“All birds”**

For each bird:
- Show  
- Edit  
- Delete  

### Aviaries
- Go to **/aviary**
- Admins see:
  - All public aviaries
  - All private aviaries
  - All users’ aviaries

Admins may edit or delete any aviary.

### Add a Bird
1. Open any garden  
2. Click **“All birds”**  
3. Click **“Add a Bird”**  
4. Submit the form  

The bird is linked to that garden.

---

## 2. User Navigation (ROLE_USER)

### Access
- Go to `/`
- Log in with a regular user account

Users are redirected to their **profile page**.

### Your Garden
Each user owns exactly one garden.

From the profile page:
- Click **“View this member’s garden”**

Users may:
- View garden information  
- Edit the garden  
- View all birds  
- Add/delete their own birds  

Users cannot view other users’ gardens.

### Your Birds
Inside your garden:
- Click **“All birds”**

Each bird:
- Show  
- Edit  
- Delete  

To add a bird:
1. Open your garden  
2. Go to **“All birds”**  
3. Click **“Add a Bird”**

The bird is linked to your garden.

### Aviaries
- On **/aviary** 

Users can view:
- All public aviaries
- Their own private aviaries

Users may:
- Edit their aviaries  
- Delete their aviaries  
- Add birds to their own aviaries  

They cannot access private aviaries belonging to others.

---

## 3. Permissions Summary

| Feature | Admin | User |
|--------|-------|------|
| View all gardens | ✔ | ✖ (only their own) |
| View all birds | ✔ | ✖ (only their own) |
| Add birds | ✔ anywhere | ✔ own garden only |
| View public aviaries | ✔ | ✔ |
| View private aviaries | ✔ all | ✔ own only |
| Edit/Delete aviaries | ✔ all | ✔ own only |
| Access protected routes | ✔ full | ✖ limited |




