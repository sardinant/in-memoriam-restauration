property ancestor, pMsgEvent
global g, gL, gSp

on new me
  (the actorList).add(me)
  me.ancestor = new(script("PS_Help_Ancestor"))
  pMsgEvent = [#click: 0]
  me.mInit()
  return me
end

on stepFrame me
  me.mStepframe()
end

on mConfirmRequest me, iSYMref
  case iSYMref of
    #TEST:
      return #yes
    otherwise:
      return #yes
  end case
end

on mMsgHelp me, iSYMtype, iLSPparam
  case iSYMtype of
    #BADPLACE:
      gSp.sound.mMsgSFX(#PHOTO_OFF)
      me.mAddRequest([#type: #INGAME, #ref: #T1, #delay: 0.0, #BLACKSC: 1, #do: "gSp.SOUND.mMsgSFX(#UNVALID)"])
    #WIN:
      me.mAddRequest([#type: #INGAME, #ref: #T2, #delay: 0.0, #BLACKSC: 1, #do: "gLocalWinTheGame()"])
  end case
end

on mInit me
  if gL.SC[g.movie].TRY = 1 then
    me.mAddRequest([#type: #MAIL, #ref: #FE06, #delay: 60 * 20.0, #time: #TOTAL])
  end if
end
