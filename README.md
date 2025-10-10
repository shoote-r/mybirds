# Information
Nom : SERIEYS
Prénom : Loris

# Presentation
This web app use is for each member to list the birds in their garden or their surroundings. Each member has a garden (inventory), birds (object) and can create aviaries (galerie).

Birds are lowkey cool so I thought they deserved more recognition yk


# How to use 
- Go on the homepage ("/").

- From there you can check the navigation bar and click on "Your Gardens", this will display all the current Gardens in the web app. You can either edit or show a garden.

- When showing a garden you see all its properties and you can display all the birds in that garden by clicking on "All birds".

- When on a bird, you can either edit or delete it.


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
 





