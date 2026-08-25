property pSprite, pState
global g, gL, gSp

on beginSprite me
  pSprite = sprite(me.spriteNum)
  pState = #on
  pSprite.visible = 1
  sprite(me.spriteNum - 1).visible = 1
  sprite(me.spriteNum - 1).locZ = the maxinteger
  gSp.GAME.pSquarreActif = 0
end

on mouseEnter me
  nothing()
end

on mouseWithin me
  cursor(280)
end

on endSprite me
end

on mouseDown me
  case pState of
    #on:
      if (pSprite.frame > 203) and (pSprite.frame <= 283) then
        pState = #off
        pSprite.visible = 0
        sprite(me.spriteNum - 1).visible = 0
        gSp.GAME.pSquarreActif = 1
        g.TARGETMARKER = "GAME"
        gSp.sound.mMsgSFX(#NEXTLEVEL)
      end if
  end case
end

on mouseUpOutSide me
  me.mouseUp()
end

on mouseLeave me
  nothing()
end

on prepareFrame me
  if gAskBusy() then
    case pState of
      #on:
        nothing()
      #off:
        nothing()
    end case
  end if
end
