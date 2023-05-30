var VF={RV:function(a,b){var c=a[0];a[0]=a[b%a.length];a[b%a.length]=c},
p4:function(a,b){a.splice(0,b)},
wa:function(a){a.reverse()}}

Isa=function(a){a=a.split("");VF.p4(a,1);VF.wa(a,42);VF.RV(a,53);VF.p4(a,1);VF.RV(a,31);VF.p4(a,3);VF.wa(a,0);VF.p4(a,2);return a.join("")}

let decryptfunc = Isa