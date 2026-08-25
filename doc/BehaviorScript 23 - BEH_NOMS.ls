property pSprite, pState, pDecMouse, pWaterProp, pBlend, pOriginalLoc, pLoc, pOldLoc, pPlace
global g, gL, gSp

on beginSprite me
  pSprite = sprite(me.spriteNum)
  pState = #WAIT_BLEND0
  pWaterProp = []
  vAlpha = random(PI * 2000) * 0.001
  pWaterProp = [vAlpha]
  pOriginalLoc = pSprite.loc
  pLoc = pOriginalLoc
  pSprite.blend = 0
  pBlend = 0.0
  gSp.GAME.pListNameSprite.add(pSprite)
end

on mouseWithin me
  if gSp.GAME.pNumImage < 3 then
    exit
  end if
  case pState of
    #wait, #INPLACE:
      cursor(280)
    #TRACKING, #TRACKING2:
      cursor(290)
  end case
end

on mouseDown me
  if gSp.GAME.pNumImage < 3 then
    exit
  end if
  if pState = #wait then
    pState = #TRACKING
    cursor(290)
    pDecMouse = pLoc - the mouseLoc
    pOldLoc = pLoc
    gSp.GAME.pTrack = pSprite
    gSp.sound.mMsgSFX(#TAKE)
  else
    if pState = #INPLACE then
      pState = #TRACKING
      cursor(290)
      pDecMouse = pLoc - the mouseLoc
      gSp.GAME.pTrack = pSprite
      gSp.sound.mMsgSFX(#TAKE)
      gSp.GAME.mDelAName(pPlace, pSprite.member.name)
    end if
  end if
end

on mouseUp me
  case pState of
    #TRACKING:
      cursor(-1)
      pState = #GOHOME
      gSp.GAME.pTrack = VOID
      gSp.sound.mMsgSFX(#RELEASE2)
    #TRACKING2:
      cursor(-1)
      pState = #INPLACE
      gSp.GAME.mAddAName(pPlace, pSprite.member.name)
      gSp.GAME.pTrack = VOID
      gSp.sound.mMsgSFX(#RELEASE1)
  end case
end

on mouseUpOutSide me
  me.mouseUp()
end

on mouseLeave me
  if gSp.GAME.pNumImage < 3 then
    exit
  end if
  if pState = #wait then
    cursor(-1)
  end if
end

on prepareFrame me
  if gAskBusy() then
    case pState of
      #WAIT_BLEND0:
      #GOTOBLEND100:
        me.bMvWater()
        if pBlend < 100 then
          pBlend = min(100, pBlend + (200 * g.frameTime))
          pSprite.blend = pBlend
        else
          pState = #wait
        end if
      #wait:
        me.bMvWater()
      #TRACKING:
        pLoc = the mouseLoc + pDecMouse
      #TRACKING2:
      #GOHOME:
        if me.bGoToPoint(pOldLoc, 600 * g.frameTime) then
          pState = #wait
        end if
      #GOHOME2:
        if me.bGoToPoint(pOldLoc, 1000 * g.frameTime) then
          pState = #wait
        end if
    end case
    pSprite.loc = pLoc
  end if
end

on bEnterZone me, theZone
  if gSp.GAME.pSoluce[2][theZone] <> EMPTY then
    exit
  end if
  case theZone of
    1:
      vPoint = point(174, 191) + point(-0.5 * pSprite.width, 0.5 * pSprite.height)
    2:
      vPoint = point(410, 459) + point(0.5 * pSprite.width, 0.5 * pSprite.height)
    3:
      vPoint = point(410, 121) + point(0.5 * pSprite.width, -0.5 * pSprite.height)
    4:
      vPoint = point(174, 285) + point(-0.5 * pSprite.width, 0.5 * pSprite.height)
    5:
      vPoint = point(649, 288) + point(0.5 * pSprite.width, 0.5 * pSprite.height)
    6:
      vPoint = point(599, 459) + point(0.5 * pSprite.width, 0.5 * pSprite.height)
  end case
  pLoc = vPoint
  pState = #TRACKING2
  pPlace = theZone
end

on bExitZone me
  pState = #TRACKING
end

on bLoose me
  pState = #GOHOME2
end

on bGoToBlend100 me
  pState = #GOTOBLEND100
end

on bMvWater me
  vAngle = 1.0 * g.frameTime
  pWaterProp[1] = pWaterProp[1] + vAngle
  vY = 7 * sin(2 * pWaterProp[1])
  vX = 7 * sin((3 * pWaterProp[1]) + (PI * 0.5))
  pLoc = pOriginalLoc + point(vX, vY)
  pSprite.loc = pLoc
  if pWaterProp[1] > (2 * PI) then
    pWaterProp[1] = pWaterProp[1] mod 2 * PI
  end if
end

on bGoToPoint me, mypoint, vitesse
  slope = mypoint - pLoc
  deltaH = slope[1]
  deltaV = slope[2]
  if integer(deltaH) then
    slope = float(deltaV) / deltaH
    angle = atan(slope)
    if deltaH < 0 then
      angle = angle + PI
    end if
  else
    if deltaV > 0 then
      angle = PI / 2
    else
      if deltaV < 0 then
        angle = 3 * PI / 2
      else
        angle = 0
      end if
    end if
  end if
  dist = sqrt((deltaH * deltaH) + (deltaV * deltaV))
  if dist <= vitesse then
    newPt = mypoint
    pLoc = newPt
    return 1
  else
    pLoc = pLoc + point(vitesse * cos(angle), vitesse * sin(angle))
    return 0
  end if
end
