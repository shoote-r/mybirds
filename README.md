# Entities
## Entity model 
- [inventaire] = garden
- [objet] = birds
- [galerie] = aviary

- [membre] = ?

## Entities association 
[inventaire]**garden**<--**(1)**-----**(0..n)**-->**birds**[objet]
		\                                            /
		 \                                          /
		  **(1)                                     (0..n)**
		   \                                      /
		    \                                    /
		     \                                  /
		      \                                /
		       \                              /
		       **(0..n)                       (0..n)**
		         \                          /
		          \                        /        
		              [galerie]**aviary**
		              

## Entities' properties 
#### User 
*Markdown tables cannot be rendered in Eclipse without a pluging which is why I'm not using them* 

**[inventaire]garden** 		              
- Properties : *description*, *NumberOfElements*
- Type : *String*, *int*
- Constraint : *notnull*, *PositiveOrZero*
- SideNote 

**[objet]birds** 
- Properties : *description*, *name*
- Type : *String*, *String*
- Constraint : none, *notnull*
- SideNote : 

NOTE : could be more developed esp. birds

#### Developer 

