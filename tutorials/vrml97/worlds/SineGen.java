import vrml.*;
import vrml.node.*;
import vrml.field.*;

public class SineGen extends Script {

   private SFFloat fraction_changed;
   //: A variable to represent our fraction_changed eventOut

   private SFFloat amplitude;
   //: A variable to represent the amplitude

   public void initialize() {
      // Grab the eventOuts and fields
      fraction_changed = (SFFloat) getEventOut("fraction_changed");
      amplitude        = (SFFloat) getField("amplitude");
   }

   public void processEvent (Event e) {
      if (e.getName().equals("set_fraction")) {
         sine((ConstSFFloat)e.getValue());
      }
   }

   private void sine (ConstSFFloat fraction) {
      double result = Math.sin(fraction.getValue() * Math.PI * 2);
      result *= amplitude.getValue();
      fraction_changed.setValue((float)result);
   }

}
