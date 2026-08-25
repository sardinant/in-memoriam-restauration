property pSprite
global g, gL, gSp

on beginSprite me
  pSprite = sprite(me.spriteNum)
  pSprite.blend = 0
end

on mouseEnter me
  if not gSp.GAME.pSecondPart then
    exit
  end if
  if gSp.GAME.pTrack <> VOID then
    gSp.GAME.pTrack.bEnterZone(me.spriteNum - 89)
  end if
  gSp.GAME.mBlink(me.spriteNum - 89)
end

on mouseLeave me
  if not gSp.GAME.pSecondPart then
    exit
  end if
  if gSp.GAME.pTrack <> VOID then
    gSp.GAME.pTrack.bExitZone(me.spriteNum - 89)
  end if
  gSp.GAME.mBlinkOff(me.spriteNum - 89)
end
